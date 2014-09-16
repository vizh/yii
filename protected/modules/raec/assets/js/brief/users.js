var CRaecBriefUsers = function () {
  this.$form = $('form#yw0');
  this.$registration = this.$form.find('.registration');
  this.userIterator = 0;
  this.init();
}
CRaecBriefUsers.prototype = {
  'init' : function () {
    var self = this;
    if (typeof (users) != "undefined") {
      $.each(users, function(i, user) {
        self.createUserRow(user);
      });
    }

    self.$form.find('input[name*="Label"]').autocomplete({
      'source' : '/user/ajax/search',
      'select' : function (event, ui) {
        self.createUserRow(ui.item);
        $(this).val('');
        return false;
      },
      'search' : function () {
        self.$registration.addClass('hide');
      },
      minLength: 2,
      response : function (event, ui) {
        if (ui.content.length != 0) {
          $.each(ui.content, function (i) {
            ui.content[i].label = ui.content[i].FullName + (typeof ui.content[i].Company != 'undefined' ? ', <span class="muted">'+ui.content[i].Company+'</span>' : '');
            ui.content[i].value = ui.content[i].FullName;
          });
        } else {
          self.$registration.removeClass('hide');
        }
      },
      html : true
    });

    self.$registration.find('.btn-submit').click(function(e) {
      var $alertError = self.$registration.find('.alert-error');

      var $fields = $('input[name*="RegisterForm"]');

      var data = {};
      $fields.each(function () {
        data[$(this).attr('name')] = $(this).val();
      });

      $.getJSON('/user/ajax/register', data, function(response) {
        $alertError.addClass('hide');
        if (response.success) {
          self.createUserRow(response.user);
          $fields.val('');
          self.$form.find('input[name*="Label"]').val('');
          self.$registration.addClass('hide');
        } else {
          $alertError.html('');
          $.each(response.errors, function (attr, errors) {
            $.each(errors, function (i, error) {
              $alertError.append(error + '<br/>');
            });
          });
          $alertError.removeClass('hide');
        }
      });
      e.preventDefault();
    });

    self.$registration.find('.btn-cancel').click(function(e) {
      e.preventDefault();
      self.$registration.addClass('hide');
    });
  },

  'createUserRow' : function (data) {
    var self = this;
    var template = _.template($('#user-tpl').html());

    data.i = self.userIterator;
    if (typeof(data.RoleId) == "undefined") {
      data.RoleId = 1;
    }
    this.$form.find('.users').append(template(data));
    var $row = this.$form.find('.users .row:last');
    $row.find('a.btn-danger').click(function(e) {
      e.preventDefault();
      $row.remove();
    });
    self.userIterator++;
  }
}

$(function () {
  new CRaecBriefUsers();
});
