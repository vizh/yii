CCabinet = function () {
  this.$container = $('.cabinet');
  this.eventIdName = this.$container.data('event-idname');
  this.$payButtons = this.$container.find('.actions a:not(.juridical)');
  this.$offerCheckbox = this.$container.find('input[name="agreeOffer"]');
  this.offerSessionName = 'offerCheckboxEnabled'+this.eventIdName;
  this.init();
}
CCabinet.prototype = {
  'init' : function () {
    var self = this;
    self.$container.find('.icon-trash').css('opacity', '0.2');
    self.$container.find('td').hover(
      function (e) {
        var $target = $(e.currentTarget);
        $target.parent('tr').find('.icon-trash').css('opacity', '0.7');
      },
      function (e) {
        var $target = $(e.currentTarget);
        $target.parent('tr').find('.icon-trash').css('opacity', '0.2');
      }
    );

    self.$offerCheckbox.change(function (e) {
      var $target = $(e.currentTarget);
      if ($target.prop('checked')) {
        self.$payButtons.removeAttr('disabled');
        self.$payButtons.addClass('btn-primary');
      }
      else {
        self.$payButtons.attr('disabled','disabled');
        self.$payButtons.removeClass('btn-primary');
      }
      $.cookie(self.offerSessionName, $target.prop('checked'), {expires:7});
    });

    if ($.cookie(self.offerSessionName) == 'true') {
      self.$offerCheckbox.attr('checked', 'checked');
    }
    self.$offerCheckbox.trigger('change');

    self.$payButtons.on('click', function () {
      return self.$offerCheckbox.prop('checked');
    });

    self.$container.find('.pay-buttons a').click(function (e) {
      $target = $(e.currentTarget);
      $form = self.$container.find('form.additional-attributes');
      if ($form.size() > 0 && !$target.is('[disabled=disabled]')) {
        $form.find('input[name*="SuccessUrl"]').val($target.attr('href'));
        $form.submit();
        return false;
      }
    });
  }
}

$(function () {
  $_ = new CCabinet();
});


























$(function () {
  var container = $('.event-register');
  var eventIdName = container.data('event-idname');

  $('.icon-trash', container).css('opacity', '0.2');
  $('td', container).hover(
    function (e) {
      $(e.currentTarget).parent('tr').find('.icon-trash').css('opacity', '0.7');
    },
    function (e) {
      $(e.currentTarget).parent('tr').find('.icon-trash').css('opacity', '0.2');
    }
  );

  var payButtons = $('.actions a:not(.juridical)', container);
  var offerCheckbox = $('input[name="agreeOffer"]', container);
  offerCheckbox.change(function (e) {
    if ($(e.currentTarget).prop('checked')) {
      payButtons.removeAttr('disabled');
      payButtons.addClass('btn-primary');
    }
    else {
      payButtons.attr('disabled','disabled');
      payButtons.removeClass('btn-primary');
    }
    $.cookie('offerCheckboxEnabled'+eventIdName, $(e.currentTarget).prop('checked'), {expires:7});
  });
  if ($.cookie('offerCheckboxEnabled'+eventIdName) == 'true') {
    offerCheckbox.attr('checked', 'checked');
  }
  offerCheckbox.trigger('change');

  payButtons.on('click', function () {
    return offerCheckbox.prop('checked');
  });


  $('.pay-buttons a').click(function (e) {
    $target = $(e.currentTarget);
    $form = $('form.additional-attributes');
    if ($form.size() > 0 && !$target.is('[disabled=disabled]')) {
      $form.find('input[name*="SuccessUrl"]').val($target.attr('href'));
      $form.submit();
      return false;
    }
  });
});