<?php

class CabinetController extends \application\components\controllers\PublicMainController
{

  public function actions()
  {
    return array(
      'register' => 'pay\controllers\cabinet\RegisterAction',
      'pay' => 'pay\controllers\cabinet\PayAction',
    );
  }
}
