$(function() {
  var t = '#event-register form > table',
      q = ['3', '2', '1', '0'], /* User quantity per event from previous page */
      idleTimer;


  /* Calculate price on page load */
  $(t).find('tr').each(function(index) {
    var $c       = $(this),
        model    = $c.data('bb-model'),
        usrCur = $c.find('select').val(),
        usrMax = q[index],
        qtyTxt = $c.find('.quantity');
    model.set('quantity', usrCur);
    if (usrMax == 0) {
      qtyTxt.text(usrMax);
    } else {
      qtyTxt.text(usrCur + ' из ' + usrMax);
    }
  });
  

  /* Adding user rows on DOM ready */
  $(t + ' select').each(function(index) {
    var $c           = $(this),
        $clsTable    = $c.closest('table'),
        $fndThead    = $clsTable.find('thead'),
        $fndTbody    = $clsTable.find('tbody'),
        usrCur       = $c.val(),
        usrMax       = q[index],
        usrRowTpl    = _.template($('#event-user-row').html()),
        usrRowTplCur = _.template($('#event-user-row-cur').html()),
        usrRowTplAdd = _.template($('#event-user-row-add').html());

    if (usrCur > 0) {
      $fndTbody.prepend(usrRowTplCur());
      for (var i = 1; i < usrMax; i++) {
        $fndTbody.append(usrRowTpl());
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
  if ($.browser.msie && parseInt($.browser.version) < 9) {
    $(t).find('.user-row:last-child').addClass('last-child');
  }


  /* Init input user autocomplete after dinamically adding user rows to DOM */
  inputUserAutocomplete();


  /* Adding/removing new user row */
  $(t + ' tbody .input-user').live('blur', function() {
    var $c            = $(this),
        $clsTable     = $c.closest('table'),
        $clsTbody     = $c.closest('tbody'),
        $clsTr        = $c.closest('tr'),
        $fndThead     = $clsTable.find('thead'),
        $fndTbody     = $clsTable.find('tbody'),
        $fndUsrRow    = $fndTbody.find('.user-row'),
        $fndUsrRowLst = $fndTbody.find('.user-row:last-child'),
        $fndInpUsr    = $fndTbody.find('.input-user'),
        $fndBtnReg    = $fndTbody.find('.btn-register'),
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
  $(t + ' .input-user').live('input keyup', function() {
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
  $(t + ' .icon-remove').live('click', function() {
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
    
    $fndInpPrm.hide().removeClass('filled');
    $fndBtnReg.hide();
    $fndInpUsr.val('').removeAttr('disabled').focus();
  });


  /* Promo code validation behavior emulation */
  $(t + ' .input-promo').live('focus', function() {
    $(this).removeClass('filled');
  }).live('blur', function() {
    var $c         = $(this),
        $clsInpWrp = $c.closest('.promo-validate');

    if ($c.val() !== '') {
      $c.wrap('<div class="promo-validate control-group success" />');
      $('<span class="help-inline">Скидка 50%</span>').insertBefore($c);
      idleTimer = setTimeout(function() {
        idleActions($c, $clsInpWrp);
      }, 3000);
    }
  });
  
  function idleActions($c, $clsInpWrp, idleTimer) {
    $c.siblings('.help-inline').fadeOut(500, function () {
      $(this).remove();
      $c.unwrap($clsInpWrp);
    });
    $c.addClass('filled');
    clearInterval(idleTimer);
  }


  /* Open register new user form */
  var usrRegTpl = _.template($('#event-user-register').html());

  $(t + ' .btn-register').live('click', function() {
    var $c         = $(this),
        $clsUsrRow = $c.closest('.user-row'),
        $fndInpPrm = $clsUsrRow.find('.input-promo');
        
    $clsUsrRow.hide();
    $fndInpPrm.removeAttr('value');
    $(usrRegTpl()).insertAfter($clsUsrRow);
    
    return false;
  });


  /* Close register new user form */
  $('#event-user-register-submit, #event-user-register-cancel').live('click', function() {
    var $c = $(this),
        $thsId     = $c.attr('id'),
        $clsTr     = $c.closest('tr'),
        $clsTrPrv  = $clsTr.prev('tr'),
        $clsTrNxt  = $clsTr.next('tr'),
        $fndInpUsr = $clsTrPrv.find('.input-user'),
        $fndInpPrm = $clsTrPrv.find('.input-promo'),
        $fndBtnReg = $clsTrPrv.find('.btn-register'),
        $fndIcnRem = $clsTrPrv.find('.icon-remove');

    $clsTr.remove();
    $clsTrPrv.show();
    $fndBtnReg.hide();

    if ($thsId == 'event-user-register-submit') {
      $fndInpUsr.attr('disabled', 'disabled');
      $fndInpPrm.removeClass('filled').show();
      $clsTrNxt.find('.input-user').focus();

      $('.input-promo').placeholder();
    }
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
      minLength: 1,
      position: {collision: 'flip'},
      source: [
        {label: "<p>Константинопольский Константин Константинович, <span class='muted'>RUNET-ID 1234567890</span></p><p class='muted'>24 года, Санкт-Петербург, Представительство Microsoft Россия, руководитель отдела разработки мобильных приложений под платформу Windows 8</p><img src='/images/content/employee_ex-photo-1.jpg' alt=''>", value: "Константинопольский Константин Константинович, RUNET-ID 1234567890"},
        {label: "<p>Медведев Дмитрий Анатольевич, <span class='muted'>RUNET-ID 0987654321</span></p><p class='muted'>40 лет, Москва, Президент Российской Федерации</p><img src='/images/content/employee_ex-photo-2.jpg' alt=''>", value: "Медведев Дмитрий Анатольевич, RUNET-ID 0987654321"},
        {label: "<p>Соколова Виктория Владимировна, <span class='muted'>RUNET-ID 2143658709</span></p><p class='muted'>Агентство Coalla, дизайнер</p><img src='/images/content/employee_ex-photo-3.jpg' alt=''>", value: "Соколова Виктория Владимировна, RUNET-ID 2143658709"}
      ],
      select: function(event, ui) {
        var $clsUsrRow = $(event.target).closest('.user-row'),
            $fndInpUsr = $clsUsrRow.find('.input-user'),
            $fndInpPrm = $clsUsrRow.find('.input-promo'),
            $fndBtnReg = $clsUsrRow.find('.btn-register');
        
        $fndInpUsr.blur().attr('disabled', 'disabled');
        $fndInpPrm.removeAttr('value').removeClass('filled').show();
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
      },
      html: true
    });
  }

});