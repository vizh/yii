<?php

class CabinetController extends \pay\components\Controller
{

  public function actions()
  {
    return array(
      'register' => 'pay\controllers\cabinet\RegisterAction',
      'index' => 'pay\controllers\cabinet\IndexAction',
    );
  }
}
