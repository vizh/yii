<?php
namespace competence\models\tests\runet2013;

class D2 extends D_base
{
  public function getNext()
  {
    return new D3($this->test);
  }

  public function getPrev()
  {
    return new D1($this->test);
  }  
}
