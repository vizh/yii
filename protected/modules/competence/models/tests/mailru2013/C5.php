<?php
namespace competence\models\tests\mailru2013;

class C5 extends \competence\models\Question
{
  public $values = [
    1 => '< 10 000 руб. в месяц',
    2 => '10 001 - 20 000',
    3 => '20 001 - 30 000',
    4 => '30 001 - 40 000',
    5 => '40 001 - 50 000',
    6 => '50 001 - 60 000',
    7 => '60 001 - 70 000 ',
    8 => 'более 70 001 руб.',
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
    return new C6($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new C4($this->test);
  }
}
