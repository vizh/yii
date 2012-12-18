var ImageViewer = null;
$(function(){
  ImageViewer = new CImageViewer('.ImageViewer');
});

var CImageViewer = function(selecter)
{
  this.container = null;
  this.Selecter = selecter;
  this.init();
};

CImageViewer.prototype.init = function()
{
  var self = this;
  $(this.Selecter).bind('click', function(e){
    self.ShowImage(e);
    return false;
  });
};

CImageViewer.prototype.GetContainer = function()
{
  if (this.container == null)
  {
    var self = this;
    var container = $('<div id="ImageViewer"></div>');
    container.css({
      'position': 'absolute',
      'z-index': 1000,
      'display': 'none',
      //'border': '30px solid #ccc',
      'background-color': '#fff',
      'padding': '10px'
    });

    var div = $('<div></div>');
    div.css({
      'border': '1px solid #ccc',
      'padding': '17px',
      'cursor': 'pointer'
    });

    var close = $('<div></div>');
    close.css({
      'float': 'right',
      'color': '#666',
      'padding-left': '15px',
      'background': 'url("/images/cross_12px.png") no-repeat scroll 0 2px transparent'
    });
    close.html('ЗАКРЫТЬ');

    div.append(
      $('<div><div style="float: left"><img src="/images/mlogo.png"></div></div>').append(close)
        .append('<div style="clear: both;"></div>')
    );
    div.append($('<img id="ImageViewer_image" src="">'));
    container.append(div);
    $('body').append(container);

    div.bind('click', function(){
      self.HideImage();
      return false;
    });

    this.container = $('#ImageViewer');
  }

  return this.container;
};

CImageViewer.prototype.ShowImage = function(e)
{
  var self = this;
  var element = $(e.currentTarget);
  var image = new Image();
  image.src = element.attr('href');
  image.onload = function(e){ self.OnLoadImage(e); };
  $('img#ImageViewer_image', this.GetContainer()).attr('src', element.attr('href'));
  this.GetContainer().css('display', 'block');
};

CImageViewer.prototype.OnLoadImage = function(e)
{
  var left = ($(window).width() - this.GetContainer().width()) / 2;
  left = Math.max(left, 0);
  var top = this.GetContainer().height() < ($(window).height - 150) ? 150 : 50;
  top += $(window).scrollTop();

  this.GetContainer().css('left', left+'px');
  this.GetContainer().css('top', top+'px');
}

CImageViewer.prototype.HideImage = function()
{
  this.GetContainer().css('display', 'none');
  $('img#ImageViewer_image', this.GetContainer()).attr('src', '');
};

