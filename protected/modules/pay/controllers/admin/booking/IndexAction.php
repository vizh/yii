<?php
namespace pay\controllers\admin\booking;

class IndexAction extends \CAction
{
  public function run()
  {
    $form = new \pay\models\forms\admin\BookingSearch();



    exit;

    $this->getController()->render('index');
  }
} 