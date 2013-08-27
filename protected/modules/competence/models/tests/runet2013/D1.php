<?php
namespace competence\models\tests\runet2013;

class D1 extends D_base
{
  public function getNext()
  {
    return new D2($this->test);
  }

  public function getPrev()
  {
    $b2Answer = $this->getFullData()[get_class(new B2($this->test))]['value'];
    $marketId = max($b2Answer);
    $b4Class = '\competence\models\tests\runet2013\B4_'.$marketId;
    $b4Answer = $this->getFullData()[get_class(new $b4Class($this->test))]['value'];
    $nextClass = '\competence\models\tests\runet2013\\'.($b4Answer == B4_base::MARKETANDCOMPANY_VALUE ? 'C10_' : 'C8_').$marketId;
    return new $nextClass($this->test);
  }  
}
