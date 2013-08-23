<?php
namespace competence\models\tests\runet2013;

class A4 extends \competence\models\Question
{
  public function init()
  {
    $employment = \Yii::app()->getUser()->getCurrentUser()->getEmploymentPrimary();
    if ($employment !== null)
    {
      $this->value = $employment->Position;
    }
    parent::init();
  }
  
  public function getNext()
  {
    return new A5($this->test);
  }

  public function getPrev()
  {
    return new A3($this->test);
  }  
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите вашу должность']
    ];
  }
}