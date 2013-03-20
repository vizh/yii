$(function () {
  var CConvertPage = function () {
    this.container = $('.container.b-convert');
    this.url = {
      'Geo - регионы' : '/convert/geo/region',
      'Geo - страны' : '/convert/geo/country',
      'Geo - города' : '/convert/geo/city',
      'Контакты - адреса' : '/convert/contact/address',
      'Контакты - email' : '/convert/contact/email',
      'Контакты - аккаунты - типы' : '/convert/contact/serviceaccounttype',
      'Контакты - аккаунты' : '/convert/contact/serviceaccount',
      'Контакты - сайты' : '/convert/contact/site',
      'Контакты - телефоны' : '/convert/contact/phone',
      'Api - аккаунты' : '/convert/api/account',
      'Партнерка - аккаунты' : '/convert/partner/account',
      'Переводы' : '/convert/translation/index',
      'Комиссии' : '/convert/commission/index',
      'Комиссии - пользователи' : '/convert/commission/user',
      'Комиссии - роли' : '/convert/commission/role',
      'Комиссии - проекты' : '/convert/commission/project',
      'Комиссии - проекты - пользователи' : '/convert/commission/projectuser',
      'Компании' : '/convert/company/index',
      'Компании - адреса' : '/convert/company/linkaddress',
      'Компании - email' : '/convert/company/linkemail',
      'Компании - телефоны' : '/convert/company/linkphone',
      'Компании - сайты' : '/convert/company/linksite',
      'Пользователи' : '/convert/user/index',
      'Пользователи - работа' : '/convert/user/employment',
      'Пользователи - адреса' : '/convert/user/linkaddress',
      'Пользователи - email' : '/convert/user/linkemail',
      'Пользователи - телефоны' : '/convert/user/linkphone',
      'Пользователи - аккаунты' : '/convert/user/linkserviceaccount',
      'Пользователи - сайты' : '/convert/user/linksite',
      'Пользователи - настройки' : '/convert/user/settings',
      'Мероприятия' : '/convert/event/index',
      'Мероприятия - участники' : '/convert/event/participants',
      'Мероприятия - адреса' : '/convert/event/linkaddress',
      'Мероприятия - дни' : '/convert/event/days',
      'Мероприятия - роли' : '/convert/event/roles',
      'Мероприятия - сайты' : '/convert/event/sites',
      'Секции' : '/convert/section/index',
      'Секции - холы' : '/convert/section/hall',
      'Секции - доклады' : '/convert/section/report',
      'Секции - роли' : '/convert/section/role',
      'Секции - пользователи' : '/convert/section/linkuser',
      'Оплаты - аккаунты' : '/convert/pay/account',
      'Оплаты - купоны' : '/convert/pay/coupon',
      'Оплаты - активации купонов' : '/convert/pay/couponactivation',
      'Оплаты - активации купонов в связки с заказами' : '/convert/pay/caloi',
      'Оплаты - счета' : '/convert/pay/order',
      'Оплаты - заказы' : '/convert/pay/orderitem',
      'Оплаты - параметры заказов' : '/convert/pay/orderitemattr',
      'Оплаты - юр. счета' : '/convert/pay/juridical',
      'Оплаты - связь заказов с счетами' : '/convert/pay/oloi',
      'Оплаты - продукты' : '/convert/pay/product',
      'Оплаты - параметры продуктов' : '/convert/pay/productattr',
      'Оплаты - цены продуктов' : '/convert/pay/productprice'
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
