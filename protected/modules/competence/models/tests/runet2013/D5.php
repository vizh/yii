<?php
namespace competence\models\tests\runet2013;

class D5 extends D_base
{
  public $positive_value;
  public $negative_value;
  
  public function getQuestionData()
  {
    return [
      'positive_value' => $this->positive_value,
      'negative_value' => $this->negative_value
    ];
  }
  
  public function getNext()
  {
    return new D6($this->test);
  }

  public function getPrev()
  {
    return new D4($this->test);
  }  
  
  public function rules()
  {
    return [
      ['positive_value, negative_value', 'required'],
      ['positive_value, negative_value', 'numerical']
    ];
  }
  
  public function attributeLabels()
  {
    return [
      'positive_value' => 'Вероятность реализации позитивного прогноза',
      'negative_value' => 'Вероятность реализации негативного прогноза'
    ];
  }
}
