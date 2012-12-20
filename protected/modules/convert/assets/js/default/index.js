$(function () {
  var CConvertPage = function () {
    this.container = $('.container.b-convert');
    this.url = {
      'Компании' : '/convert/company/index',
      'Пользователи' : '/convert/user/index',
      'Пользователи - работа' : '/convert/user/employment',
      'Мероприятия' : '/convert/event/index',
      'Мероприятия - участники' : '/convert/event/participants'
    }
    this.init();
  }
  CConvertPage.prototype = {
    init : function () {
      var self = this;
      $.each(self.url, function (title, url) {
        self.container.find('input').before(title+' <div class="progress" data-url="'+url+'"><div class="bar"></div></div></div>');
      });
      
      self.container.find('input').click(function(e) {
        $(e.currentTarget).remove();
        self.runNextUrl();
      });
    },
    
    sendRequest : function (url, progressBar) {
      var self = this;
      $.getJSON(url, function (response) {
        if (response.success != true) {
          var procent = Math.round(response.step / response.stepAll * 100);
          progressBar.find('.bar').css('width', procent+'%');
          self.sendRequest(response.nextUrl, progressBar);
        }
        else {
          progressBar.find('.bar').css('width', '100%').addClass('bar-success');
          progressBar.addClass('success');
          self.runNextUrl();
        }
      });
    },
    
    runNextUrl : function () {
      var self = this;
      var progressBar = self.container.find('.progress:not(.success)').eq(0);
      if (progressBar.size() != 0) {
        self.sendRequest(progressBar.data('url'), progressBar);
      }
      else {
        self.container.find('h2').after('<div class="alert alert-success">База успешно перемещена!</div>');
      }
    }
  }
  
  var ConvertPage = new CConvertPage();
});
