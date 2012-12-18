var LinearChart = function(options) {

  this.createOn = function(parentID) {
    calculateValues();
    var
        $parent = $('#' + parentID),
        $graph  = div("charts-linear"),
        $legend = div("charts-linear_datetime");

    _.each(options.items, function(item) {
      var
        $p = div("items clearfix").css({width: pr(item.inPercent)});

      _.each(item.parts, function(part) {
        div("item").css({
          background: part.color,
          width: pr(part.inPercent)
        }).appendTo($p).attr('data-original-title', 'Участие ' + part.role + ': ' + part.val);
      });

      $graph.append(div("items_wrap").append($p));
      $legend.append(div('datetime').append(div('year').html(item.year + 'г')));
    });
    div().addClass('clearfix').append($graph).append($legend).appendTo($parent);
  };

  function calculateValues() {
    var
      maxVal = _.max(_.map(options.items, function(item) {
        item.total = _.reduce(item.parts, function(mem, e) { return mem + e.val; }, 0);
        return item.total;
      }));

    _.each(options.items, function(item) {
      item.inPercent = percent(item.total, maxVal);
      _.each(item.parts, function(part) {
        part.inPercent = percent(part.val, item.total);
      });
    });
  }

  function div(cls) {
    if (cls) {
      return $('<div class="' + cls + '"/>');
    } else {
      return $('<div />');
    }
  }

  function percent(value, from) { return value / from * 100; }
  function pr(val) { return val + "%"; }

};

var Chart = function(options) {

  this.createOn = function(parentID) {
    var 
      lastPos = 0,
      total = _.reduce(options.parts, function(t, part) { return t + part.val; }, 0),
      compiled = _.template(options.itemTemplate);

    var i = 0;

    _.each(options.parts, function(part) {
      var
        div = $(compiled({value: part.val, role: part.role})),
        canvas = document.getElementById(options.charts[i]);
      if (typeof(G_vmlCanvasManager) != 'undefined') G_vmlCanvasManager.initElement(canvas);
      var 
        ctx = canvas.getContext("2d"),
        radius = (options.height - options.border.size) / 2,
        origin = radius + options.border.size / 2,
        disp = options.disp,
        delta = (options.clockwise ? 1 : -1) * options.avail * part.val / total;

      canvas.width = canvas.height = radius * 2 + options.border.size;
      ctx.lineWidth = options.border.size;
      ctx.lineCap = "butt";

      ctx.beginPath();
      ctx.strokeStyle = options.border.color;
      
      if (typeof(G_vmlCanvasManager) != 'undefined') {
        ctx.arc(origin, origin, radius, disp, disp, !options.clockwise);
      } else {
        ctx.arc(origin, origin, radius, disp, (options.clockwise ? 1 : -1) * options.avail + disp, !options.clockwise);
      }

      ctx.stroke();

      ctx.beginPath();
      ctx.strokeStyle = part.color;
      ctx.arc(origin, origin, radius, disp + lastPos, disp + lastPos + delta, !options.clockwise);
      lastPos += delta;
      ctx.stroke();

      $('#' + options.charts[i]).parent().append(div);

      i++;

    });
  }

};

var RunetChart = function(options) {

  this.createOn = function(parentID) {
    this.parts = _.sortBy(options.parts, function(e) { return e.val; });
    this.parts = options.parts;
    var 
      avail = Math.PI,
      disp =  1.5 * Math.PI,
      lastPos = 0,
      total = _.reduce(options.parts, function(t, part) { return t + part.val; }, 0),
      canvas = document.getElementById('charts-single_canvas');
    if (typeof(G_vmlCanvasManager) != 'undefined') G_vmlCanvasManager.initElement(canvas);
    var
      ctx = canvas.getContext("2d"),
      radius = (options.height - options.border.size) / 2,
      padding = 50,
      br = radius + options.border.size / 2 + padding / 2,
      ox, oy,
      compiled = _.template(options.itemTemplate);

    var e = this.parts.shift();
    this.parts.push(e);

    canvas.height = radius * 2 + options.border.size + padding + 1;
    canvas.width  = radius + options.border.size / 2 + padding / 2;

    ox = canvas.width;
    oy = canvas.height / 2;

    ctx.lineWidth = options.border.size;
    ctx.lineCap = "butt";
   
    _.each(this.parts, function(part) {
      var 
        delta = -avail * part.val / total,
        alpha = disp + lastPos,
        beta = alpha + delta,
        gamma = (alpha + beta) / 2 - disp;

      ctx.strokeStyle = part.color;
      ctx.beginPath();
      
      ctx.arc(ox, oy, radius, alpha, beta, true);
      lastPos += delta;
      ctx.stroke();

      part.percent = Math.round(part.val / total * 100);
      part.cx = Math.round(ox + radius * Math.sin(gamma)) + 0.5;
      part.cy = Math.round(oy - radius * Math.cos(gamma)) + 0.5;

      part.bx = Math.round(ox + br * Math.sin(gamma)) + 0.5;
      part.by = Math.round(oy - br * Math.cos(gamma)) + 0.5;

      ctx.beginPath();
      ctx.fillStyle = "#666";
      ctx.arc(part.cx, part.cy, 4, 0, 2 * Math.PI, false);
      ctx.fill();
    });

    ctx.strokeStyle = "#666";
    ctx.lineWidth = 1;

    drawPart(ctx, this.parts[0]);
    if (this.parts.length > 2) {
      var 
        availHgt = this.parts[this.parts.length - 1].by - this.parts[0].by,
        step = availHgt / (this.parts.length - 1);

      for (var i = 1; i < this.parts.length - 1; i++) {
        var 
          ny = br - this.parts[0].by,
          p = this.parts[i];

        ny -= i * step;
        var 
          cosGamma = ny / br,
          gamma = Math.acos(cosGamma),
          x = br * Math.sin(gamma);
        p.bx = -Math.round(x) + canvas.width + 0.5;
        p.by = -Math.round(ny) + br + 0.5;
        drawPart(ctx, p);
      }
    }

    if (this.parts.length > 1) {
      drawPart(ctx, this.parts[this.parts.length - 1]);  
    }

    var
      parent = $('<div class="items"></div>'),
      prevElement;
    for (var i = 0; i < this.parts.length; i++) {
      var
        part = this.parts[i],
        e = $(compiled({value: part.percent, role: part.role}));
      if (i > 0) {
        var hgt = Math.round(part.by) - Math.round(this.parts[i - 1].by) - 1;
        prevElement.css({"height": hgt + "px"});
      }
      prevElement = e;
      parent.append(e);
    }

    parent.css({"padding-top": (Math.round(this.parts[0].by) - 1)+ "px"});

    $('#' + parentID).append(parent);
  };

  function drawPart(ctx, p) {
    ctx.beginPath();
    ctx.moveTo(p.cx, p.cy);
    ctx.lineTo(p.bx, p.by);
    ctx.lineTo(0, p.by);
    ctx.stroke();
  }

};