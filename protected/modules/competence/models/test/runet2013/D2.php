<?php
namespace competence\models\tests\runet2013;

class D2 extends D_base
{
  public function __construct($test, $scenario = '')
  {
    parent::__construct($test, $scenario);
    $this->value = [];
    foreach ($this->getTrends() as $trend)
    {
      $this->value[$trend] = 0;
    }
  }
  
  public function getNext()
  {
    return new D3($this->test);
  }

  public function getPrev()
  {
    return new D1($this->test);
  }  
}
