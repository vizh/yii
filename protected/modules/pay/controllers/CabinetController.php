<?php

class CabinetController extends \pay\components\Controller
{

  public function actions()
  {
    return array(
      'register' => 'pay\controllers\cabinet\RegisterAction',
      'index' => 'pay\controllers\cabinet\IndexAction',
      'deleteitem' => 'pay\controllers\cabinet\DeleteItemAction',
      'pay' => 'pay\controllers\cabinet\PayAction',
      'return' => 'pay\controllers\cabinet\ReturnAction'
    );
  }
}
