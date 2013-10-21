<?php
namespace competence\models\tests\runet2013;

class D4 extends D_base
{
  public function __construct($test, $scenario = '')
  {
    parent::__construct($test, $scenario);
    $this->value = [];
    foreach ($this->getFactors() as $factor)
    {
      $this->value[$factor] = 0;
    }
  }
  
  public function getNext()
  {
    return new D5($this->test);
  }

  public function getPrev()
  {
    return new D3($this->test);
  }  
}
