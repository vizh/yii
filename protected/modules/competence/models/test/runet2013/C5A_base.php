<?php
namespace competence\models\tests\runet2013;

abstract class C5A_base extends \competence\models\Question
{
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\C5_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $c8Name = '\competence\models\tests\runet2013\C8_'.$this->getMarketId();
    $c8 = new $c8Name($this->test);
    $options = $c8->getOptions();
    if (empty($options))
    {
      return $c8->getNext();
    }
    return $c8;
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
    return 'competence.views.tests.runet2013.c5a';
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
      'value' => 'Количество человек'  
    ];
  }
}

