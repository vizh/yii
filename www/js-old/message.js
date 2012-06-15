  function selection(className) {
    var status = $('choose').getProperty('checked');
    var elements = $$('input').filterByClass(className);

    elements.each(function(element, i) {
      if (status === true ) {
        element.setProperty('checked', 'checked');
      }
      else if (status === false) {
        element.setProperty('checked', '');
      }
    });
  }

  function getMessages(elem, visible) {
    var elem_id = $(elem).getProperty('id');

    if (visible == 'show') {
      $(elem_id).setStyle('display', 'block');
      $('group_' + elem_id).setStyle('background-color', '#D2E8F7');
      $('open_' + elem_id).setStyle('display', 'none');
      $('close_' + elem_id).setStyle('display', 'block');
    }
    else if (visible == 'hide') {
      $(elem_id).setStyle('display', 'none');
      $('group_' + elem_id).setStyle('background-color', '');
      $('open_' + elem_id).setStyle('display', 'block');
      $('close_' + elem_id).setStyle('display', 'none');
    }
  }