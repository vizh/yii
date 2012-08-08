<?php
namespace application\components\controllers;

class PublicController extends BaseController
{
  public $layout = '//layouts/public';

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
    $cs = \Yii::app()->clientScript;
  }

}
