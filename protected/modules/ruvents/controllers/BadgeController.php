<?php


class BadgeController extends ruvents\components\Controller
{

  public function actions()
  {
    return array(
      'list' => 'ruvents\controllers\badge\ListAction',
      'create' => 'ruvents\controllers\badge\CreateAction'
    );
  }
}