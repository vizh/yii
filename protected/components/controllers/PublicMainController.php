<?php
namespace application\components\controllers;

class PublicMainController extends BaseController
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
}
