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
          1  => 'Веб-разработка',
          2  => 'Контекстная реклама',
          3  => 'Медийная реклама',
          4  => 'Видеореклама',
          5  => 'Маркетинг в социальных медиа (SMM)',
          6  => 'Поисковая оптимизация'
        ];
      case 2:
        return [
          7  => 'Программное обеспечение как услуга (SaaS)',
          8  => 'Хостинг',
          9  => 'Домены',
        ];
      case 3:
        return [
          10 => 'Ретейл',
          11 => 'Электронные платежи',
          12 => 'Контент',
          13 => 'Туризм'
        ];
      case 4:
        return [
          14 => 'Игры'  
        ];
      case 5:
        return [
          15 => 'Работа',
          16 => 'Образование'
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

