window.addEvent('domready', function() {
  
  // Начало пополнения кошелька
  $('paymentForm').addEvent('submit', function(e) {
    new Event(e).stop();
    this.send({
      update: $('formIncrease')
    });
  });

});