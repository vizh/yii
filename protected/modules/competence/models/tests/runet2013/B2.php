<?php
namespace competence\models\tests\runet2013;

class B2 extends \competence\models\Question
{
  public $value = [];
  
  public function getOptions()
  {
    $b1Answer = $this->getFullData()[get_class(new B1($this->test))];
    switch($b1Answer['value'])
    {
      case 1:
        return [
          1  => ['Веб-разработка','Услуги в области разработки интернет-сайтов (включая дизайн и стиль сайтов, тестирование и проектирование их «юзабилити» и т.д.).'],
          2  => ['Контекстная реклама','Услуги по размещению рекламы с оплатой за результат (поисковая реклама, таргетированная реклама, лидогенерация)'],
          3  => ['Медийная реклама','Услуги по размещению рекламы внутри медиаконтента.'],
          4  => ['Видеореклама','Услуги по размещению видеорекламы внутри размещаемого в Интернете видеоконтента (на хостингах видео, в онлайн-кинотеатрах и т.д.).'],
          5  => ['Маркетинг в социальных медиа (SMM)',' Услуги по продвижению товаров и услуг, а также связям с общественностью в социальных медиа (исключая рекламу в социальных сетях), а также услуги аналитических сервисов.'],
          6  => ['Поисковая оптимизация','Услуги в области улучшения «видимости» сайтов в результатах поиска через поисковые системы.']
        ];
      case 2:
        return [
          7  => ['Программное обеспечение как услуга (SaaS)','Модель продажи и использования программного обеспечения, при которой поставщик разрабатывает веб-приложение и самостоятельно управляет им, предоставляя заказчику доступ к программному обеспечению через Интернет.'],
          8  => ['Хостинг','Услуги по предоставлению вычислительных мощностей для размещения и/или хранения информации на серверах, постоянно находящихся в Интернете.'],
          9  => ['Домены','Предоставление доменных имен в Интернете.']
        ];
      case 3:
        return [
          10 => ['Онлайн-ритейл','Продажа физических товаров и оффлайновых услуг (блиеты на мероприятия, купоны и др.) через Интернет.'],
          11 => ['Электронные платежи','Рынок онлайн расчетов между компаниями и пользователями за товары и услуги в Интернете.'],
          12 => ['Контент','Продажи и дистрибуция цифрового контента (аудио, видео, книги и периодика, неигровые приложения).'],
          13 => ['Туризм','']
        ];
      case 4:
        return [
          14 => ['Игры','Особый вид услуг, который предполагает доставку игр через Интернет, включая игры в социальных сетях и на мобильных платформах, а также продажу виртуальных товаров и сервисов внутри игровых приложений.']  
        ];
    }
  }
  
  public function getPrev()
  {
    return new B1($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\B3_'.min($this->value);
    return new $nextClass($this->test);
  }
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Необходимо выбрать один или несколько рынков для продолжения']
    ];
  }
}

