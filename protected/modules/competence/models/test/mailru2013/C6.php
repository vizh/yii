<?php
namespace competence\models\tests\mailru2013;

class C6 extends \competence\models\Question
{
  public $value = array();

  public $values = [
    1 => 'API',
    2 => 'Аналитика',
    3 => 'Веб-разработка / Технологии',
    4 => 'Видео',
    5 => 'Геосервисы',
    6 => 'Государство и общество',
    7 => 'Домены и Хостинг',
    8 => 'Игры',
    9 => 'Инвестиции и стартапы',
    10 => 'Интернет-СМИ',
    11 => 'Интернет-маркетинг',
    12 => 'Интернет-провайдинг',
    13 => 'Интернет-сервисы',
    14 => 'Информационная безопасность',
    15 => 'Кадры',
    16 => 'Мобильные технологии и приложения',
    17 => 'Облака',
    18 => 'Образование',
    19 => 'Поисковая оптимизация',
    20 => 'Поисковые технологии',
    21 => 'Право в интернете',
    22 => 'Регионы',
    23 => 'Реклама',
    24 => 'Социальные медиа',
    25 => 'Социальный интранет',
    26 => 'Электронная торговля и платежи',
  ];

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите от одной до трех сфер интересов'],
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    if (sizeof($this->value) > 3)
    {
      $this->addError('value', 'Выберите не более трех сфер интересов');
      return false;
    }
    return true;
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return null;
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new C5($this->test);
  }

  public function getNumber()
  {
    return 29;
  }
}
