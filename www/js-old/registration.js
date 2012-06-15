var Registration = {
  
  start: function() {
    if ($('search_lastname_firstname')) Registration.getUserByName($('search_lastname_firstname'));
  },
  
  getUserByName: function (el) {
    el.addEvent('keyup', function(e) {
      var value = el.getValue();
      if (value.length > 3) {
        wu.AjaxTimed(1000, '/system/modules/registration/remote/users.get.php?get=user&search=' + value, 'search_result', true, '');
      }
    });
  },            
  
  getLoginForm: function (rocid) {
    var complete = function () {
      $('search_lastname_firstname').setProperty('disabled', 'disabled');
      Registration.doLogin();
    }
    wu.Ajax('/system/modules/registration/remote/users.get.php?get=login_form&rocid=' + rocid, 'search_result', true, complete);
  },
  
  doLogin: function () {
    $('registration_login_button').addEvent('click', function(e) {
      wu.Ajax('/system/modules/registration/remote/users.get.php?get=login&' + $('registration_login').toQueryString(), 'search_result', true, '');
    });
  } 

};

window.addEvent('domready', function() {
  Registration.start();
});