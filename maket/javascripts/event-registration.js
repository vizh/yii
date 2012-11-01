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
  $(evRegTbl + ' .user-row input:checkbox').live('click', function() {
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
    source: [
      {label: "<p>Константинопольский Константин Константинович, <span class='muted'>RUNET-ID 1234567890</span></p><p class='muted'>24 года, Санкт-Петербург, Представительство Microsoft Россия, руководитель отдела разработки мобильных приложений под платформу Windows 8</p><img src='/images/content/employee_ex-photo-1.jpg' alt=''>", value: "Константинопольский Константин Константинович, RUNET-ID 1234567890"},
      {label: "<p>Медведев Дмитрий Анатольевич, <span class='muted'>RUNET-ID 0987654321</span></p><p class='muted'>40 лет, Москва, Президент Российской Федерации</p><img src='/images/content/employee_ex-photo-2.jpg' alt=''>", value: "Медведев Дмитрий Анатольевич, RUNET-ID 0987654321"}
    ],
    select: function(event, ui) {
      var $closestTr = $(event.target).closest('tr');
      $closestTr.find('.btn-user_register').hide();
      $closestTr.find('.btn-user_add').show();
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
        getInputVal   = $findInput.val();
    $(this).closest('tbody').append(userRowTemplate({username: getInputVal}));
    $findInput.val('').focus();
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
  $('#event-user-register-submit, #event-user-register-cancel').live('click', function() {
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