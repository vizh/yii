<?php
namespace partner\components\widgets;

class BottomMenu extends \CWidget
{
  public $menu = array();

  public function run()
  {
    $this->render('bottomMenu');
  }
}
