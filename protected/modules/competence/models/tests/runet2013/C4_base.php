<?php
namespace competence\models\tests\runet2013;

abstract class C4_base extends \competence\models\Question
{
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\C3_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\C5_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  /**
   * @return int
   */
  abstract public function getMarketId();
  
  /**
   * @return string
   */
  abstract public function getMarketTitle();
  
  protected function getDefinedViewPath()
  {
    return 'competence.views.tests.runet2013.c4';
  }
  
  public function rules()
  {
    return [
      ['value', 'numerical', 'allowEmpty' => true]
    ];
  }
  
  public function attributeLabels()
  {
    return [
      'value' => 'Количество компаний'  
    ];
  }
}

