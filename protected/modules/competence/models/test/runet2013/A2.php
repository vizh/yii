<?php
namespace competence\models\tests\runet2013;

class A2 extends \competence\models\Question
{
  public function init()
  {
    if (!empty(\Yii::app()->getUser()->getCurrentUser()->Birthday))
    {
      $this->value = \Yii::app()->getDateFormatter()->format('dd.MM.yyyy', \Yii::app()->getUser()->getCurrentUser()->Birthday);
    }
    parent::init();
  }
  
  public function getNext()
  {
    return new A3($this->test);
  }

  public function getPrev()
  {
    return new First($this->test);
  }  
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите дату вашего рождения']
    ];
  }
}
