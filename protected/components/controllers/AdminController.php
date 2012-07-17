<?php
namespace application\components\controllers;

class AdminController extends BaseController
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
}
