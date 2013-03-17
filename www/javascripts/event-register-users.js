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
          runetid: user.runetid,
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
    $(t).find('.user-row:last-child').addClass('last-child');
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
        $.post('/runetid2/userajax/checkcode/', postData, function(data){
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
            var runetid = data.RunetId;
            $fndInpUsr.before(usrRowTpl({productid: productid, runetid: runetid}));
            $fndInpPrm.removeAttr('value').attr('name', usrPrmTpl({productid: productid, runetid: runetid}));
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
    var userAutocompleteTpl = _.template($('#user-autocomlete-tpl').html());

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
        var runetid = ui.item.runetid;
        $fndInpUsr.before(usrRowTpl({productid: productid, runetid: runetid}));

        $fndInpUsr.blur().attr('disabled', 'disabled');
        $fndInpPrm.removeAttr('value').removeClass('filled').attr('name', usrPrmTpl({productid: productid, runetid: runetid})).show();
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

        for (var i=0; i<ui.content.length; i++)
        {
          ui.content[i].label = userAutocompleteTpl({
            item: ui.content[i]
          });
          ui.content[i].value = ui.content[i].FullName + ', RUNET-ID ' + ui.content[i].RunetId;
        }
      },
      html: true
    });
  }

});

function decodeEntities(input) {
  var y = document.createElement('textarea');
  y.innerHTML = input;
  return y.value;
}