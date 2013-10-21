<?php
namespace competence\models\tests\runet2013;

class A5 extends \competence\models\Question
{
  public $position;
  public $company;
  public $industry;
  
  protected function getQuestionData()
  {
    return [
      'position' => $this->position,
      'company'  => $this->company,
      'industry' => $this->industry
    ];
  }
  
  
  public function getNext()
  {
    return new A6($this->test);
  }

  public function getPrev()
  {
    return new A4($this->test);
  }  
  
  public function rules()
  {
    return [
      ['position', 'required', 'message' => 'Укажите сколько лет вы работаете в указанной должности'],
      ['company', 'required', 'message' => 'Укажите сколько лет вы работаете в указанной компании'],
      ['industry', 'required', 'message' => 'Укажите сколько лет вы работаете в индустрии, связанной с интернетом'],
    ];
  }
}