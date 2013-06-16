<?php
namespace competence\models\tests\mailru2013;

class C1 extends \competence\models\Question
{

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Впишите, пожалуйста, полное количество лет'],
      ['value', 'numerical', 'message' => 'Введенное значение должно быть числом']
    ];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new C2($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $first = new First($this->test);
    return $first->getS3();
  }
}
