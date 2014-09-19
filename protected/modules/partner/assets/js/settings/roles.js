var CPartnerSettingsRoles = function () {
  this.$table = $('table.table.table-striped');
  this.$form = this.$table.find('tfoot tr form.form-inline');
  this.$formInput = this.$form.find('input#Role');
  this.$formButton = this.$form.find('button');
  this.init();
}
CPartnerSettingsRoles.prototype = {
  'init' : function () {
    var self = this;
    self.loadRoles();

    self.$formInput.autocomplete({
      'source' : '?Action=search',
      'select' : function (event, ui) {
        self.sendRequest('link', {'RoleId' : ui.item.value});
        $(this).val('');
        return false;
      },
      response: function( event, ui ) {
        if (ui.content.length == 0) {
          self.$formButton.removeClass('hide');
        }
        else {
          self.$formButton.addClass('hide');
        }
      }
    });

    self.$formButton.click(function (e) {
      e.preventDefault();
      self.sendRequest('create', {'RoleTitle' : self.$form.find('input#Role').val()});
      self.$formInput.val('');
    });
  },
  'loadRoles' : function () {
    var self = this;
    self.$table.find('tbody').html('<tr><td colspan="3" style="text-align: center;">Идет загрузка...</td></tr>');
    $.getJSON('?', {'Action' : 'list'}, function (response) {
      self.$table.find('tbody').html('');
      $.each(response, function (i, role) {
        var $tr = $('<tr/>', {
          'html' : '<td style="width: 10px">'+(role.CanDelete ? '<a href="#" class="btn-delete"><i class="icon-trash"></i></a>' : '')+'</td><td>'+role.Title+'</td>'+
            '<td><input type="text" class="input-small" name="color" value="' + (role.Color) + '" readonly="readonly" ' + (role.Color.length > 0 ? ('style="background-color:' + role.Color + '"') : '') + '/></td>'
        });

        $tr.find('input[name="color"]').colpick({
          'layout' : 'hex',
          'color'  : role.Color,
          'submit' : false,
          'onChange' : function (hsb, hex, rgb, element) {
            $(element).val('#'+hex);
            $(element).css('background-color', '#'+hex);
          },
          'onHide'  : function(element) {
            $.getJSON('?', {'Action' : 'setcolor', 'RoleId' : role.Id, 'Color' : $tr.find('input[name="color"]').val()});
          }
        });
        if (role.CanDelete) {
          $tr.find('a.btn-delete').click(function (e) {
            e.preventDefault();
            self.sendRequest('delete', {'RoleId' : role.Id});
          });
        }
        self.$table.find('tbody').append($tr);
      });
    });
  },
  'sendRequest' : function (action, params) {
    var self = this;
    $.getJSON('?', $.extend({'Action' : action}, params), function (response) {
      self.loadRoles();
    },'json');
  }
}


$(function () {
  new CPartnerSettingsRoles();
});