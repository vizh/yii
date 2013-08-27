<?php
namespace competence\models\tests\runet2013;

class A7 extends \competence\models\Question
{
  public $academic_degree;
  public $academic_degree_value;
  public $academic_title;
  public $academic_title_value;
  public $MBA_degree;
  public $MBA_degree_value;
  
  protected function getQuestionData()
  {
    return [
      'academic_degree'       => $this->academic_degree,
      'academic_degree_value' => $this->academic_degree_value,
      'academic_title'        => $this->academic_title,
      'academic_title_value'  => $this->academic_title_value,
      'MBA_degree'            => $this->MBA_degree,
      'MBA_degree_value'      => $this->MBA_degree_value
    ];
  }
  
  
  public function getNext()
  {
    return new B1($this->test);
  }

  public function getPrev()
  {
    return new A6($this->test);
  }  
  
  public function rules()
  {
    return [
      ['academic_degree', 'required', 'message' => 'Укажите есть ли у вас ученая степень'],
      ['academic_title', 'required', 'message' => 'Укажите есть ли у вас ученое звание'],
      ['MBA_degree', 'required', 'message' => 'Укажите есть ли у вас степерь MBA'],
    ];
  }
}