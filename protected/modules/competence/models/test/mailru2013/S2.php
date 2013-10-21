<?php
namespace competence\models\tests\mailru2013;

class S2 extends \competence\models\Question
{
  public $value;

  public function rules()
  {
    return array(
      array('value', 'required', 'message' => 'Впишите, пожалуйста, полное количество лет'),
      array('value', 'numerical', 'message' => 'Введенное значение должно быть числом')
    );
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new E1_1($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return null;
  }
}