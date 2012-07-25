<?php
namespace partner\controllers\order;

class IndexAction extends \CAction
{
  public function run()
  {
    $this->getController()->render('index');
  }
}