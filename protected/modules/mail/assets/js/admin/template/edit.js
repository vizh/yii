var CTemplateEdit = function () {
  this.criteriaIterator = 0;
  this.roles = [];
  this.init();
}
CTemplateEdit.prototype = {
  init : function () {
    var self = this;
    $('button.add-criteria-btn').click(function (e) {
      var method = 'create'+$(e.currentTarget).data('by')+'Criteria';
      self[method]();
    });


    $('input#confirm-template').change(function (e) {
      var button = $('button[name*="Active"]');
      if (button.is(':disabled'))
        button.removeAttr('disabled');
      else
        button.attr('disabled', 'disabled');
    });

    $('input[name*="TestUsers"]').autocomplete({
      'source' : function(request, response) {
        var terms = request.term.split(/,\s*/);
        var term = terms.pop();
        if (term.length > 2)
        {
          $.getJSON('/user/ajax/search', {term : term}, function (data) {
            response(data);
          });
        }
      },
      focus: function() {
        return false;
      },
      select: function( event, ui ) {
        var terms = this.value.split(/,\s*/);
        terms.pop();
        terms.push( ui.item.value );
        terms.push( "" );
        this.value = terms.join( ", " );
        return false;
      }
    });

    if ($('textarea[name*="Template[Body]"]').length > 0) {
      CKEDITOR.replace('mail\\models\\forms\\admin\\Template[Body]', {
        customConfig : 'config_mail_template.js',
        height : 500
      });
    }
  },

  createEventCriteria : function (data) {
    var self = this;
    var iterator = self.criteriaIterator;
    var template = _.template($('#event-criteria-tpl').html())({i : iterator});
    $('#filter').append(template);
    var row = $('#filter>div:last');
    row.find('.btn-danger').click(function() {
      row.remove();
    });
    row.find('input[name*="eventLabel"]').autocomplete({
      'source' : '/event/ajax/search',
      'select' : function (event, ui) {
        this.value = ui.item.value+', '+ui.item.label;
        row.find('input[name*="eventId"]').val(ui.item.value);
        return false;
      }
    });


    row.find('input[name*="rolesSearch"]').autocomplete({
      source : self.roles,
      select : function (event, ui) {
        createRoleField(ui.item);
        this.value = '';
        return false;
      }
    });

    function createRoleField (item) {
      var label = $('<span class="label"></span>');
      label.html(item.label+' <a href="#">x</a><input type="hidden" name="mail\\models\\forms\\admin\\Template[Conditions]['+iterator+'][roles][]" value="'+item.value+'"/>');
      label.css('margin','5px 10px 0 0');
      row.find('input[name*="rolesSearch"]').after(label);
      label.find('a').click(function (e) {
        e.preventDefault();
        label.remove();
      });
    }

    if (typeof data != "undefined") {
      row.find('input[name*="eventId"]').val(data.eventId);
      row.find('input[name*="eventLabel"]').val(data.eventLabel);
      if (typeof data.roles != "undefined") {
        $.each(data.roles, function (i, value) {
          $.each(self.roles, function (j, role) {
            if (role.value == value) {
              createRoleField(role);
              return false;
            }
          });
        });
      }
      row.find('select[name*="type"] option[value="'+data.type+'"]').attr('selected', 'selected');
    }
    this.criteriaIterator++;
  },

  createEmailCriteria : function (data) {
    var self = this;
    var iterator = self.criteriaIterator;
    var template = _.template($('#email-criteria-tpl').html())({i : iterator});
    $('#filter').append(template);
    var row = $('#filter>div:last');
    row.find('.btn-danger').click(function() {
      row.remove();
    });

    if (typeof data != "undefined") {
      row.find('textarea[name*="emails"]').val(data.emails);
      row.find('select[name*="type"] option[value="'+data.type+'"]').attr('selected', 'selected');
    }
    this.criteriaIterator++;
  },

  createRunetIdCriteria : function (data) {
    var self = this;
    var iterator = self.criteriaIterator;
    var template = _.template($('#runetid-criteria-tpl').html())({i : iterator});
    $('#filter').append(template);
    var row = $('#filter>div:last');
    row.find('.btn-danger').click(function() {
      row.remove();
    });

    if (typeof data != "undefined") {
      row.find('textarea[name*="runetIdList"]').val(data.runetIdList);
      row.find('select[name*="type"] option[value="'+data.type+'"]').attr('selected', 'selected');
    }
    this.criteriaIterator++;
  }
}

$(function () {
  TemplateEdit = new CTemplateEdit();
});