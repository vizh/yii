$(function() {
  var PriceItem = Backbone.Model.extend({
    defaults: {
      quantity: 0
    },

    getTotalPrice: function() {
      return this.get('price') * this.get('quantity');
    }
  });

  var PriceItems = Backbone.Collection.extend({
    model: PriceItem,

    getGrandTotal: function() {
      return this.reduce(function(memo, e) {
        return memo + e.getTotalPrice();
      }, 0);
    }
  });

  var PriceItemView = Backbone.View.extend({
    tagName: 'tr',
    events: {
      'change select' : 'updateQuantity'
    },

    initialize: function() {
      var bind = function (func, thisValue) {
        return function () {
          return func.apply(thisValue, arguments);
        }
      };

      this.model.on('change:quantity', bind(this.render, this));
    },

    updateQuantity: function(e) {
      var qty = parseInt($(e.target).find(':selected').val());
      this.model.set('quantity', qty);
    },

    render: function() {
      if (this.model.hasChanged('quantity')) {
        this.$el.find('.mediate-price').text(this.model.getTotalPrice().formatMoney());
      }
    }
  });
    
  var priceItems = (new PriceItems);

  $('.registration > table').find('tr').each(function() {
    var price = $(this).attr('data-price');
    if (price) {
      var model = (new PriceItem);
      model.set('price', parseInt(price));

      priceItems.add([model]);

      var view = new PriceItemView({model: model});
      view.setElement(this);

      $(this).data('bb-model', model);
    }
  });

  priceItems.on('change:quantity', function() {
    $('#total-price').text(priceItems.getGrandTotal().formatMoney());
  });
});


$(function() {
  var t = '#event-register form > table',
    idleTimer; /* User quantity per event from previous page */


  /* Calculate price on page load */
  $(t).find('tr').each(function() {
    var $c       = $(this),
      model    = $c.data('bb-model'),
      usrMax = $c.data('user-max'),
      usrCur = $c.data('user-current'),
      qtyTxt = $c.find('.quantity');
    model.set('quantity', usrCur);
    if (usrMax == 0) {
      qtyTxt.text(usrMax);
    } else {
      qtyTxt.text(usrCur + ' из ' + usrMax);
    }
  });

  alert($(t));

  /* Adding user rows on DOM ready */
  $(t + ' thead tr').each(function() {
    var $c           = $(this),
      $clsTable    = $c.closest('table'),
      //$fndThead    = $clsTable.find('thead'),
      $fndTbody    = $clsTable.find('tbody'),
      usrMax       = $c.data('user-max'),
      usrRowTpl    = _.template($('#event-user-row').html()),
      usrRowTplWithData = _.template($('#event-user-row-withdata').html()),
      usrRowTplAdd = _.template($('#event-user-row-add').html()),
      productid = $c.data('product-id');
      
      
    if (typeof(products[productid]) != 'undefined')
    {
      for (var index in products[productid])
      {
        var user = products[productid][index];
        $fndTbody.append(usrRowTplWithData({
          productid: productid,
          rocid: user.rocid,
          name: user.name,
          code: user.code
        }));
      }
    }
    else
    {
      if (usrMax > 0) {
        $fndTbody.prepend(usrRowTplWithData({
          productid: productid,
          runetid: currentUser.runetid,
          name: currentUser.name,
          code: currentUser.code
        }));

        for (var i = 1; i < usrMax; i++) {
          $fndTbody.append(usrRowTpl());
        }
      }
    }
    $fndTbody.append(usrRowTplAdd());
    if (usrMax < 2) {
      $fndTbody.find('.user-row:last-child').css({'opacity': '1'});
      $fndTbody.find('.user-row:last-child .input-user').removeAttr('disabled');
    }
  });


  /* For IE */
  /* Init placeholder for IE < 10 */
  $('.input-user, .input-promo').placeholder();


  /* Getting tr:last-child for IE < 9 */
    //if ($.browser.msie && parseInt($.browser.version) < 9) {
    //$(t).find('.user-row:last-child').addClass('last-child');
  //}


  /* Init input user autocomplete after dinamically adding user rows to DOM */
  inputUserAutocomplete();


  /* Adding/removing new user row */
  $(t + ' tbody .input-user').on('blur', function() {
    var $c            = $(this),
      $clsTable     = $c.closest('table'),
      $clsTbody     = $c.closest('tbody'),
      $clsTr        = $c.closest('tr'),
      $fndThead     = $clsTable.find('thead'),
      $fndTbody     = $clsTable.find('tbody'),
    //$fndUsrRow    = $fndTbody.find('.user-row'),
      $fndUsrRowLst = $fndTbody.find('.user-row:last-child'),
      $fndInpUsr    = $fndTbody.find('.input-user'),
    //$fndBtnReg    = $fndTbody.find('.btn-register'),
      trgInpEmpty   = 0,
      trgInpFilled  = 0,
      usrRowTpl     = _.template($('#event-user-row').html());

    /* Counting quantity of empty/filled input values */
    $fndInpUsr.each(function() {
      if ($(this).val() == '' /* -> for IE */ || $(this).val() == 'Введите ФИО или RUNET-ID') {
        trgInpEmpty++;
      } else {
        trgInpFilled++;
      }
    });

    /* Input disabling/enabling, removing/adding */
    if (trgInpEmpty == 0) {
      $fndTbody.append(usrRowTpl());
      inputUserAutocomplete($clsTable);
      $('.input-user').placeholder();
    }
    if (trgInpEmpty == 2 && trgInpFilled == 1 || trgInpEmpty == 2 && trgInpFilled == 0 || trgInpEmpty == 1 && trgInpFilled > 0) {
      $fndUsrRowLst.css({'opacity': '1'});
      $fndUsrRowLst.find('.input-user').removeAttr('disabled');
    }
    if (trgInpEmpty !== 1 && $c.val() == '' /* -> for IE */ || $(this).val() == 'Введите ФИО или RUNET-ID') {
      $clsTr.remove();
    }

    /* Calculate user quantity and price on input value change */
    $fndThead.find('tr').each(function() {
      var $c     = $(this),
        model  = $c.data('bb-model'),
        usrMax = $clsTbody.find('tr').length;

      $c.find('select > option').attr('value', trgInpFilled).text(trgInpFilled);
      if(trgInpEmpty < 3 && trgInpFilled < 1) {
        $c.find('.quantity').text('0');
      } else {
        $c.find('.quantity').text(trgInpFilled + ' из ' + (usrMax - 1));
      }

      model.set('quantity', trgInpFilled);
    });

    clearInterval(idleTimer);
  });


  /* Button disabling/enabling. Input show/hide */
  $(t + ' .input-user').on('input keyup', function() {
    var $c         = $(this),
      $clsTr     = $c.closest('tr'),
      $clsTd     = $c.closest('td'),
      $fndIcnRem = $clsTr.find('.icon-remove'),
      $fndBtnReg = $clsTr.find('.btn-register');

    $fndIcnRem.remove();

    if ($c.val() == '') {
      $fndBtnReg.hide();
    } else {
      $clsTd.find('.p-relative').append('<i class="icon-remove"></i>');
    }
  });


  /* Empty filled input value */
  $(t + ' .icon-remove').on('click', function() {
    var $c         = $(this),
      $clsTr     = $c.closest('tr'),
      $fndInpUsr = $clsTr.find('.input-user'),
      $fndInpPrm = $clsTr.find('.input-promo'),
      $fndInpWrp = $clsTr.find('.promo-validate'),
      $fndInpHlp = $clsTr.find('.help-inline'),
      $fndBtnReg = $clsTr.find('.btn-register');

    $c.remove();

    if ($fndInpWrp.length > 0) {
      $fndInpHlp.remove();
      $fndInpPrm.unwrap($fndInpWrp);
    }

    $fndInpUsr.prev().remove();
    $fndInpPrm.hide().removeClass('filled').removeAttr('name');
    $fndBtnReg.hide();
    $fndInpUsr.val('').removeAttr('disabled').focus();
  });


  /* Promo code validation behavior emulation */
  $(t + ' .input-promo').on('focus', function() {
    $(this).removeClass('filled');
  }).on('blur', function() {
      var $c         = $(this),
        $clsInpWrp = $c.closest('.promo-validate');

      if ($c.val() !== '') {
        var name = $c.attr('name');
        var postData = {};
        postData[name] = $c.val();
        $.post('/user/ajax/search/', postData, function(data){
          if (typeof(data) != 'undefined')
          {
            if (data.Error)
            {
              $c.wrap('<div class="promo-validate control-group error" />');
              $('<div class="alert alert-error">'+data.Message+'</div>').insertBefore($c);
            }
            else
            {
              $c.wrap('<div class="promo-validate control-group success" />');
              $('<div class="help-inline">'+data.Message+'</span>').insertBefore($c);
            }

            idleTimer = setTimeout(function() {
              idleActions($c, $clsInpWrp);
            }, 3000);
          }
        }, 'json');
      }
    });

  function idleActions($c, $clsInpWrp, idleTimer) {
    $c.siblings('.help-inline').fadeOut(500, function () {
      $(this).remove();
      $c.unwrap($clsInpWrp);
    });
    $c.siblings('.alert').fadeOut(500, function () {
      $(this).remove();
      $c.unwrap($clsInpWrp);
    });
    $c.addClass('filled');
    clearInterval(idleTimer);
  }


  /* Open register new user form */
  var usrRegTpl = _.template($('#event-user-register').html());

  $(t + ' .btn-register').on('click', function() {
    var $c         = $(this),
      $clsUsrRow = $c.closest('.user-row'),
      $fndInpPrm = $clsUsrRow.find('.input-promo');

    $clsUsrRow.hide();
    $fndInpPrm.removeAttr('value');
    $(usrRegTpl()).insertAfter($clsUsrRow);

    return false;
  });


  /* Close register new user form */
  $('#event-user-register-submit, #event-user-register-cancel').on('click', function() {
    var $c = $(this),
      $thsId     = $c.attr('id'),
      $clsTr     = $c.closest('tr'),
      $clsTrPrv  = $clsTr.prev('tr'),
      $clsTrNxt  = $clsTr.next('tr'),
      $fndInpUsr = $clsTrPrv.find('.input-user'),
      $fndInpPrm = $clsTrPrv.find('.input-promo'),
      $fndBtnReg = $clsTrPrv.find('.btn-register'),
      $fndIcnRem = $clsTrPrv.find('.icon-remove');

    var usrRowTpl = _.template($('#event-user-row-hiddenitem').html());
    var usrPrmTpl = _.template($('#event-user-row-promoname').html());

    if ($thsId == 'event-user-register-submit')
    {
      var $form = $clsTr.find('form');
      $.post('/runetid2/userajax/register/', $form.serializeArray(), function(data){
        if (typeof(data) != 'undefined')
        {
          if (data.Success)
          {
            var productid = $clsTrPrv.parents('table').find('thead tr').data('product-id');
            var rocid = data.RocId;
            $fndInpUsr.before(usrRowTpl({productid: productid, rocid: rocid}));
            $fndInpPrm.removeAttr('value').attr('name', usrPrmTpl({productid: productid, rocid: rocid}));
            $fndInpUsr.attr('value', data.FullName);


            $clsTr.remove();
            $clsTrPrv.show();
            $fndBtnReg.hide();

            $fndInpUsr.attr('disabled', 'disabled');
            $fndInpPrm.removeClass('filled').show();
            $clsTrNxt.find('.input-user').focus();

            $('.input-promo').placeholder();
          }
          else
          {
            var alert = $clsTr.find('.alert');
            if (alert.length == 0)
            {
              alert = $('<div class="alert alert-error"></div>');
              $clsTr.find('header').after(alert);
              //<div class="alert alert-error">Вы допустили ошибки при заполнении формы.<br>Проверьте введенные данные.</div>
            }
            alert.html('');
            for (index in data.ErrorMsg)
            {
              alert.append($('<p>'+data.ErrorMsg[index]+'</p>'));
            }
          }
        }
      }, 'json');
      return false;
    }

    $clsTr.remove();
    $clsTrPrv.show();
    $fndBtnReg.hide();

    if ($thsId == 'event-user-register-cancel') {
      $fndInpUsr.removeAttr('value').focus();
      $fndInpPrm.hide();
      $fndIcnRem.remove();
    }

    return false;
  });

  /* Input user autocomplete */
  function inputUserAutocomplete(current) {
    var c;

    if (current) {
      c = current.find('.input-user');
    } else {
      c = $(t + ' .input-user');
    }

    return c.autocomplete({
      minLength: 2,
      position: {collision: 'flip'},
      source: '/user/ajax/search/',
      select: function(event, ui) {
        var $clsUsrRow = $(event.target).closest('.user-row'),
          $fndInpUsr = $clsUsrRow.find('.input-user'),
          $fndInpPrm = $clsUsrRow.find('.input-promo'),
          $fndBtnReg = $clsUsrRow.find('.btn-register');

        var usrRowTpl = _.template($('#event-user-row-hiddenitem').html());
        var usrPrmTpl = _.template($('#event-user-row-promoname').html());
        var productid = $clsUsrRow.parents('table').find('thead tr').data('product-id');
        var rocid = ui.item.rocid;
        $fndInpUsr.before(usrRowTpl({productid: productid, rocid: rocid}));

        $fndInpUsr.blur().attr('disabled', 'disabled');
        $fndInpPrm.removeAttr('value').removeClass('filled').attr('name', usrPrmTpl({productid: productid, rocid: rocid})).show();
        $fndBtnReg.hide();

        $('.input-promo').placeholder();
      },
      close: function(event, ui) {
        var $clsUsrRow = $(event.target).closest('.user-row'),
          $fndInpUsr = $clsUsrRow.find('.input-user'),
          $fndBtnReg = $clsUsrRow.find('.btn-register');

        if ($fndInpUsr.val() !== '') {
          $fndBtnReg.show();
        }
      },
      response: function(event, ui) {
        var $clsUsrRow = $(event.target).closest('.user-row'),
          $fndBtnReg = $clsUsrRow.find('.btn-register');
  
        if (ui.content.length === 0) {
          $fndBtnReg.show();
        } else {
          $fndBtnReg.hide();
        }
      }
    });
  }
});

$(function() {
  var evRegTbl = '#event-register .registration .table';

  /* Setting data attributes on DOM ready */
  $(evRegTbl + ' .form-element_select').each(function() {
    var $closestTable = $(this).closest('table'),
        $findTbody = $closestTable.find('tbody');
    var currentQty = $(this).find(':checked').attr('value');
    $findTbody.attr('data-attr-qty', currentQty);
    updateCheckboxes($findTbody);
  });

  /* Set background to selected user row */
  $(evRegTbl + ' .user-row input:checkbox').on('click', function() {
    var $closestTr    = $(this).closest('tr'),
        $closestTbody = $(this).closest('tbody');
    updateCheckboxes($closestTbody);
  });

  /* Update checkboxes */
  function updateCheckboxes($tbody) {
    var $closestTbody        = $tbody,
        maxCheckboxesQty     = parseInt($closestTbody.attr('data-attr-qty')),
        $findNotSelected     = $closestTbody.find('input:checkbox:not(:checked)'),
        checkedCheckboxesQty = $closestTbody.find(':checked').size();
        
    if (checkedCheckboxesQty >= maxCheckboxesQty) {
      $findNotSelected.hide();
    } else {
      $findNotSelected.show();
    }
  }

  /* Clear checkboxes checked state and background on select change */
  $(evRegTbl + ' .form-element_select').change(function() {
    var $closestTable = $(this).closest('table'),
        $findCheckbox = $closestTable.find('.user-row input:checkbox'),
        $findTbody    = $closestTable.find('tbody'),
        $findTr       = $closestTable.find('tr');
    $findCheckbox.removeAttr('checked');
    $findTr.removeClass('success');
    var currentQty = $(this).find(':checked').attr('value');
    $findTbody.attr('data-attr-qty', currentQty);
    updateCheckboxes($findTbody);
  });

  /* Autocomplete */
  $(evRegTbl + ' .autocomplete').autocomplete({
    minLength: 1,
    position: {collision: 'flip'},
    source: '/user/ajax/search/',
    select: function(event, ui) {
      var $closestTr = $(event.target).closest('tr');
      $closestTr.find('.btn-user_register').hide();
      $closestTr.find('.btn-user_add').show();
      $closestTr.find('.form-element_text')
        .data('rocid', ui.item.rocid)
        .data('productid', $(this).data('productid'));
      
      $(event.target).attr('data-already-selected', 'true');
    },
    html: true
  });
  
  /* Add user from autocomplete */
  var userRowTemplate = _.template($('#event-user-row').html());

  $(evRegTbl + ' .btn-user_add').click(function() {
    var $closestTr    = $(this).closest('tr'),
        $closestTbody = $(this).closest('tbody'),
        $findInput    = $closestTr.find('.form-element_text'),
        getInputVal   = $findInput.val(),
        getInputRocId = $findInput.data('rocid'),
        getInputProductId = $findInput.data('productid'); 
        
    $(this).closest('tbody tr.user-action-row').before(userRowTemplate({username: getInputVal, rocid: getInputRocId, productid: getInputProductId}));
    $findInput.val('').focus();
    if ($closestTbody.find(':checked').size() < parseInt($closestTbody.attr('data-attr-qty'))) {
      $closestTbody.find('input:checkbox:last').attr('checked', 'checked');
    }
    
    updateCheckboxes($closestTbody);
    return false;
  });

  /* Open register new user form */
  var userRegisterTemplate = _.template($('#event-user-register').html());

  $(evRegTbl + ' .btn-user_register').click(function() {
    var $closestTbody            = $(this).closest('tbody'),
        $findUserActionRow       = $closestTbody.find('.user-action-row'),
        $findUserActionRowInput  = $closestTbody.find('.user-action-row .form-element_text'),
        $findUserActionRowBtnReg = $closestTbody.find('.user-action-row .btn-user_register');
    
    $findUserActionRow.hide();
    $findUserActionRowInput.val('');
    $findUserActionRowBtnReg.attr('disabled', 'disabled');
    $closestTbody.prepend(userRegisterTemplate());
    return false;
  });

  /* Close register new user form */
  $('#event-user-register-submit, #event-user-register-cancel').on('click', function() {
    var $closestTbody            = $(this).closest('tbody'),
        $closestTr               = $(this).closest('tr'),
        $findUserActionRow       = $closestTbody.find('.user-action-row'),
        $findUserActionRowInput  = $closestTbody.find('.user-action-row .form-element_text');
    $closestTr.remove();
    $findUserActionRow.show();
    $findUserActionRowInput.focus();
    return false;
  });

  /* Buttons Disabled/Enabled, Show/Hide */
  $(evRegTbl + ' .form-element_text').bind('input keyup focus', function() {
    var $closestTr = $(this).closest('tr'),
        $findBtn   = $closestTr.find('.btn');

    if (!$(this).attr('data-already-selected')) {
      $closestTr.find('.btn-user_register').show();
      $closestTr.find('.btn-user_add').hide();
    } else {
      $(this).removeAttr('data-already-selected');
    }
    if ($(this).val() == '') {
      $findBtn.attr('disabled', 'disabled');
    } else {
      $findBtn.removeAttr('disabled');
    }
  });
});

Number.prototype.formatMoney = function(c, d, t){
  var n = this,
    c = c == undefined ? 0 : isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "," : d,
    t = t == undefined ? " " : t,
    s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
