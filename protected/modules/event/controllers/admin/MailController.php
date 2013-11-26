<?php
class MailController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return [
      'register' => '\event\controllers\admin\mail\RegisterAction'
    ];
  }
} 