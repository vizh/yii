<?php
namespace competence\models\tests\runet2013;

abstract class C7_base extends \competence\models\Question
{
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\C5A_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $c8Name = '\competence\models\tests\runet2013\C8_'.$this->getMarketId();
    $c8 = $c8Name($this->test);
    
    $options = $c8->getOptions();
    if (empty($options[$this->getMarketId()]))
    {
      return $c8->getNext();
    }
    return $c8();
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
    return 'competence.views.tests.runet2013.c7';
  }
}

