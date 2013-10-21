<?php
namespace competence\models\tests\runet2013;

abstract class C3_base extends \competence\models\Question
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
    $nextClass = '\competence\models\tests\runet2013\C2_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\C4_'.$this->getMarketId();
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
    return 'competence.views.tests.runet2013.c3';
  }
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите какова будет общая динамика оборота компаний на российском рынке']
    ];
  }
}



