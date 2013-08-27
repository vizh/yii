<?php
namespace competence\models\tests\runet2013;

class D3 extends D_base
{
  public function getNext()
  {
    return new D4($this->test);
  }

  public function getPrev()
  {
    return new D2($this->test);
  }  
}
