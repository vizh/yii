<?php
namespace competence\models\tests\runet2013;

abstract class C6_base extends \competence\models\Question
{
  public $company = [];
  public $percentages = [];
  
  public function getQuestionData()
  {
    return [
      'company' => $this->company,
      'percentages' => $this->percentages
    ];
  }
  
  
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\C5_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\C7_'.$this->getMarketId();
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
    return 'competence.views.tests.runet2013.c6';
  }
  
  public function rules()
  {
    return [
      ['company', 'filter', 'filter' => [$this, 'filterValues']]
    ];
  }
  
  public function filterValues($values)
  {
    for($i = 1; $i <= sizeof($this->company); $i++)
    {
      if (!empty($this->company[$i]) && intval($this->percentages[$i]) == 0)
        $this->addError('percentages', 'Укажите долю рынка в процентах для компании');
      else if (empty($this->company[$i]) && intval($this->percentages[$i]) != 0)
        $this->addError('company', 'Укажите компанию');
    }
    return $values;
  }
}

