CPayAdminBookingParking = function () {
  this.$well  = $('.container-fluid>.well');
  this.$form  = this.$well.children('form');
  this.$table = this.$well.children('table.table');
  this.init();
};

CPayAdminBookingParking.prototype = {
  'init' : function () {
    var self = this;
    self.$form.find('input[name*="DateIn"], input[name*="DateOut"]').datepicker({
      'minDate' : new Date(2014, 3, 23),
      'maxDate' : new Date(2014, 3, 25)
    });

    self.$form.submit(function () {
      var data = self.$form.serializeArray();
      var $alertError = self.$form.find('.alert-error');

      var $submitBtn = self.$form.find('[type="submit"]');
      $submitBtn.data('value', $submitBtn.val()).addClass('active').val('Подождите...');

      $alertError.html('').addClass('hide');
      $.post('?action=addParking', data, function (response) {
        if (typeof response.errors != "undefined") {
          var $ul = $('<ul/>');
          $.each(response.errors, function (i, error) {
            $ul.append('<li>'+error+'</li>');
          });
          $alertError.append($ul).removeClass('hide');
          $submitBtn.removeClass('active').val($submitBtn.data('value'));
        }
        else if (response.success) {
          var $alertSuccess = $('<div/>', {
            'class' : 'alert alert-success',
            'html' : 'Номер автомобиля успешно сохранен!'
          });
          self.$form.html('').append($alertSuccess);
          document.location.reload();
        }
      }, 'json');
      return false;
    });

    self.$well.find('input#query').keyup(function (e) {
      var $target = $(e.currentTarget);
      self.$table.find('tbody tr').each(function () {
        var $row = $(this);
        if ($row.find('td:first').text().indexOf($target.val()) == -1) {
          $row.hide();
        }
        else {
          $row.show();
        }
      });
    });
  }
}


$(function () {
  var $_ = new CPayAdminBookingParking();
});
