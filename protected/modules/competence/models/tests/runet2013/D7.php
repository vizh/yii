<?php
namespace competence\models\tests\runet2013;

class D7 extends D_base
{
  public function getNext()
  {
    return null;
  }

  public function getPrev()
  {
    return new D6($this->test);
  }  
}
