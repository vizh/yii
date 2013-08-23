<?php
namespace competence\models\tests\runet2013;

abstract class C10_base extends \competence\models\Question
{
  public $increase_value;
  public $decrease_value;
  
  protected function getQuestionData()
  {
    return [
      'value' => $this->value,
      'increase_value' => $this->increase_value,
      'decrease_value' => $this->decrease_value
    ];
  }
  
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\C9_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $b2Answer = $this->getFullData()[get_class(new B2($this->test))]['value'];
    sort($b2Answer);
    $key = array_search($this->getMarketId(), $b2Answer);
    if (isset($b2Answer[$key+1]))
      $nextClass = 'B3_'.$b2Answer[$key+1];
    else
      $nextClass = 'D1';
    
    $nextClass = '\competence\models\tests\runet2013\\'.$nextClass;
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
    return 'competence.views.tests.runet2013.c10';
  }
}



