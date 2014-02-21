<?php
class MailController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return [
      'index' => '\event\controllers\admin\mail\IndexAction',
      'edit'  => '\event\controllers\admin\mail\EditAction'
    ];
  }
} 