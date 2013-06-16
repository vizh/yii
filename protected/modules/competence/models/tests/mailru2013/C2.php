<?php
namespace competence\models\tests\mailru2013;

class C2 extends \competence\models\Question
{
  public $values = [
    1 => 'Мужской',
    2 => 'Женский'
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
    return new C3($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new C1($this->test);
  }
}
