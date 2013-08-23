<?php
namespace competence\models\tests\runet2013;

class First extends \competence\models\Question
{
  public function init()
  {
    $this->value = \Yii::app()->getUser()->getCurrentUser()->getFullName();
    parent::init();
  }
  
  public function getNext()
  {
    return new A2($this->test);
  }

  public function getPrev()
  {
    return null;
  } 
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите вашу фамилию, имя, отчество']
    ];
  }
}
