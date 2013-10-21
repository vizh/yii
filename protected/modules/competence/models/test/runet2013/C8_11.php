<?php
namespace competence\models\tests\runet2013;

class C8_11 extends C8_1
{
  public function getMarketId()
  {
    return 11;
  }

  public function getMarketTitle()
  {
    return 'Электронные платежи';
  }  
  
  protected function getDefinedViewPath()
  {
    return 'competence.views.tests.runet2013.c8_11';
  }
}
