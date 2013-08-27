<?php
namespace competence\models\tests\runet2013;

class A3 extends \competence\models\Question
{
  public function init()
  {
    $employment = \Yii::app()->getUser()->getCurrentUser()->getEmploymentPrimary();
    if ($employment !== null)
    {
      $this->value = $employment->Company->Name;
    }
    parent::init();
  }
  
  public function getNext()
  {
    return new A4($this->test);
  }

  public function getPrev()
  {
    return new A2($this->test);
  }  
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите ваше основное место работы']
    ];
  }
}