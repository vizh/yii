<?php
namespace competence\models\tests\runet2013;

abstract class C1_base extends \competence\models\Question
{
  public function getPrev()
  {
    $prevClass = '\competence\models\tests\runet2013\B3_'.$this->getMarketId();
    $b3Answer = $this->getFullData()[get_class(new $prevClass($this->test))]['value'];;
    if ($b3Answer != 'нет')
    {
      $prevClass = '\competence\models\tests\runet2013\B4_'.$this->getMarketId();
    }
    return new $prevClass($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\C2_'.$this->getMarketId();
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
    return 'competence.views.tests.runet2013.c1';
  }
  
  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Укажите вашу оценку общего оборота компаний на российском рынке']
    ];
  }
}

