<?php
namespace competence\models\tests\mailru2013;

class S7 extends \competence\models\Question
{

  public $values = [
    1 => 'Нет подчинённых',
    2 => '1-4 человека',
    3 => '5-10 человек',
    4 => '11-50 человек',
    5 => '51-100 человек',
    6 => 'Более 100 человек',
    99 => 'Затрудняюсь ответить'
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
    $first = new First($this->test);
    return $first->getS3();
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new S6($this->test);
  }
}
