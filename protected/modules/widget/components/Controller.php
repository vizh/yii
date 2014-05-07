<?php
namespace widget\components;

class Controller extends \application\components\controllers\BaseController
{
  public $layout = '/layouts/public';

  protected function initResources()
  {
    \Yii::app()->getClientScript()->registerPackage('runetid.widget');
    parent::initResources();
  }


} 