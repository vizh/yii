<?php
namespace competence\models\tests\runet2013;

class D4 extends D_base
{
  public function getNext()
  {
    return new D5($this->test);
  }

  public function getPrev()
  {
    return new D3($this->test);
  }  
}
