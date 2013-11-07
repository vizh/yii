<?php

class FilterController extends \application\components\controllers\AdminMainController
{
  public function actions()
  {
    return [
      'index' => '\mail\controllers\admin\filter\IndexAction',
    ];
  }
}