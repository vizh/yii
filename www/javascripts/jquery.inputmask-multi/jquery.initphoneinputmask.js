(function( $ ) {
  var phoneCodeList = $.masksSort($.masksLoad("/javascripts/jquery.inputmask-multi/phone-codes.json"), ['#'], /[0-9]|#/, "mask");

  $.fn.initPhoneInputMask = function() {
    var input = $(this);
    var options = {
      inputmask: {
        definitions: {
          '#': {
            validator: "[0-9]",
            cardinality: 1
          }
        },
        showMaskOnHover: false,
        autoUnmask: true
      },
      match: /[0-9]/,
      replace: '#',
      list: phoneCodeList,
      listKey: 'mask'
    };
    input.inputmasks(options);
    return input;
  };
})(jQuery);
