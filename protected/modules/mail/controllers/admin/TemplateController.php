<?php

class TemplateController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return [
      'index' => '\mail\controllers\admin\template\IndexAction',
      'edit'  => '\mail\controllers\admin\template\EditAction',
      'deleteattachment'  => '\mail\controllers\admin\template\DeleteAttachmentAction'
    ];
  }
}