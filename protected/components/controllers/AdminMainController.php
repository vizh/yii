<?php
namespace application\components\controllers;

class AdminMainController extends MainController
{
  public $layout = '//layouts/admin';

  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array()
    );
  }

  protected function initResources()
  {
    parent::initResources();

    \Yii::app()->getClientScript()->registerPackage('runetid.admin');
  }

}
