<?php
namespace competence\models\tests\runet2013;

abstract class B4_base extends \competence\models\Question
{
  const MARKET_VALUE = 'рынок';
  const MARKETANDCOMPANY_VALUE = 'рынок и компания';
  
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\B3_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\C1_'.$this->getMarketId();
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
    return 'competence.views.tests.runet2013.b4';
  }
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите вашу готовность предоставить детальную информацию о своей компании ны рынке']
    ];
  }
}

