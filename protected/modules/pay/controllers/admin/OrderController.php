<?php

class OrderController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return array(
      'index' => '\pay\controllers\admin\order\IndexAction',
      'view' => '\pay\controllers\admin\order\ViewAction',
      'print' => '\pay\controllers\admin\order\PrintAction'
    );
  }

}