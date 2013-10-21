<?php
namespace competence\models\tests\mailru2013;

class C4 extends \competence\models\Question
{
  public $values = [
    1 => 'Неполное среднее',
    2 => 'Среднее/ среднее-специальное',
    3 => 'Неполное высшее',
    4 => 'Высшее',
    5 => 'PhD/ кандидат наук',
    6 => 'Доктор наук',
    9 => 'Отказ от ответа',
  ];

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите один ответ из списка']
    ];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new C5($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new C3($this->test);
  }

  public function getNumber()
  {
    return 27;
  }
}
