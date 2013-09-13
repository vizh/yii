<?php
namespace competence\models\tests\runet2013;

abstract class C9_base extends \competence\models\Question
{
  public function getPrev()
  {
    $c8Name = '\competence\models\tests\runet2013\C8_'.$this->getMarketId();
    $c8 = new $c8Name($this->test);
    $options = $c8->getOptions();
    if (!empty($options))
    {
      $prevClass = $c8Name;
    }
    else
    {
      $prevClass = '\competence\models\tests\runet2013\C5A_'.$this->getMarketId();
    }
    return new $prevClass($this->test);
  }
  
  public function getNext()
  {
    $nextClass = '\competence\models\tests\runet2013\C10_'.$this->getMarketId();
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
    return 'competence.views.tests.runet2013.c9';
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
      'value' => 'Оборот вашей компании'  
    ];
  }
}

