function get(elem) {
  var id = $(elem).getProperty('id');
  $(id + '_value').setProperty('disabled', (elem.checked === true) ? false : true);
}