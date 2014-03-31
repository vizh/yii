(function($) {
  $(function() {
    $('a.cancel').click(function(e) {
      e.preventDefault();
      window.location.reload();
    });

    // Переходим по шагам
    $('a[name*="step"]').click(function(e) {
      e.preventDefault();
      var nextStepName = this.name;

      function moveToNextStep() {
        $('#' + nextStepName).show();
      }

      switch (nextStepName)
      {
        case 'step2':
          if (step2())
            moveToNextStep();
          break;
        case 'step3':
          if (step3())
            moveToNextStep();
          break;
      }
    });

    /**
     * Переход на шаг 2
     * @returns {boolean}
     */
    function step2() {
      var $payerRunetId = $('input[name="payerRunetId"]');
      if (!$payerRunetId.length)
        throw new Error('Элемент с именем payerRunetId не найден!');

      var payerRunetId = $payerRunetId.val();
      $('#step1 .alert.alert-error').remove();
      if (!payerRunetId.length) {
        var $error = $('<div class="alert alert-error">Получатель счета не выбран!</div>');
        $payerRunetId.closest('.span12').prepend($error);
        return false;
      }
      new COrderEdit({'payerRunetId' : payerRunetId});
      $('#step1 input').attr('disabled', 'disabled');
      $('#step1 .buttons').hide();
      return true;
    }

    /**
     * Переход на шаг 3
     * @returns {boolean}
     */
    function step3() {
      $('#step2 .alert.alert-error').remove();
      if (!$('#step2 table#order-items tbody tr').length) {
        var $error = $('<div class="alert alert-error">Список товаров пуст! Добавьте товары.</div>');
        $('#step2 .span12.indent-bottom1').prepend($error);
        return false;
      }

      $('#step2 input, #step2 button, #step2 select').attr('disabled', 'disabled');
      $('#step2 .buttons').hide();

      $('form').submit(function() {
        $('input, button, select').removeAttr('disabled');
      });
      return true;
    }
  });
})(jQuery);