<?php
namespace competence\models\tests\runet2013;

abstract class B3_base extends \competence\models\Question
{
  public function getPrev()
  {
    $b2Answer = $this->getFullData()[get_class(new B2($this->test))]['value'];
    sort($b2Answer);
    $key = array_search($this->getMarketId(), $b2Answer);
    if (isset($b2Answer[$key-1]))
    {
      $prevClass = '\competence\models\tests\runet2013\B3_'.$b2Answer[$key-1];
      return new $prevClass($this->test);
    }
    else
    {
      $b1Answer = $this->getFullData()[get_class(new B1($this->test))]['value'];
      if ($b1Answer == 4)
      {
        return new B1($this->test);
      }
      return new B2($this->test);
    }
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\B4_'.$this->getMarketId();
    if ($this->value == 'нет')
    {
      $b4 = new $nextClass($this->test);
      $b4->value = B4_base::MARKET_VALUE;
      $b4->parse();
      $nextClass = '\competence\models\tests\runet2013\C1_'.$this->getMarketId();
    }
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
    return 'competence.views.tests.runet2013.b3';
  }
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите является ли ваша компания участником рынка']
    ];
  }
}

