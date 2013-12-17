var CTemplateEdit = function () {
  this.criteriaIterator = 0;
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

    CKEDITOR.replace('mail\\models\\forms\\admin\\Template[Body]', {
      height: 500
    });
  },

  createEventCriteria : function (data) {
    var template = _.template($('#event-criteria-tpl').html())({i : this.criteriaIterator});
    $('#filter').append(template);
    var row = $('#filter>div:last');
    row.find('.btn-danger').click(function() {
      row.remove();
    });
    row.find('input[name*="eventId"]').autocomplete({
      'source' : '/event/ajax/search'
    });

    if (typeof data != "undefined") {
      row.find('input[name*="eventId"]').val(data.eventId);
      if (typeof data.roles != "undefined") {
        $.each(data.roles, function (i, value) {
          row.find('select[name*="roles"] option[value="'+value+'"]').attr('selected', 'selected');
        });
      }
      row.find('select[name*="type"] option[value="'+data.type+'"]').attr('selected', 'selected');
    }
    this.criteriaIterator++;
  }
}

$(function () {
  TemplateEdit = new CTemplateEdit();
});