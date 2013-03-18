<?php
namespace application\components\controllers;

class PublicMainController extends MainController
{
  public $layout = '//layouts/public';
  public $bodyId = 'index-page';


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

    \Yii::app()->getClientScript()->registerPackage('runetid.application');
  }
}
