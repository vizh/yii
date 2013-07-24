<?php
class EditController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return [
      'index' => '\event\controllers\admin\edit\IndexAction',
      'widget' => '\event\controllers\admin\edit\WidgetAction'
    ];
  }
}
