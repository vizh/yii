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
    if ($b4Answer == B4_base::MARKETANDCOMPANY_VALUE)
    {
      $prevClass = 'C10';
    }
    else
    {
      $c8Name = '\competence\models\tests\runet2013\C8_'.$marketId;
      $c8 = new $c8Name($this->test);
      $options = $c8->getOptions();
      $prevClass = 'C'.(!empty($options) ? '8' : '5A');
    }
    $prevClass = '\competence\models\tests\runet2013\\'.$prevClass.'_'.$marketId;
    return new $prevClass($this->test);
  }  
}
