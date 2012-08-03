<?php

class OrderController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'index' => '\partner\controllers\order\IndexAction',
      'create' => '\partner\controllers\order\CreateAction',
      'view' => '\partner\controllers\order\ViewAction',
      'search' => '\partner\controllers\order\SearchAction',
    );
  }

  public function getBottomMenu

  ()
  {
    return array(
      array(
        'Title' => '',
        'Url' => '',
        'Access' => '',
        'Active' => ''
      ),
      array(),
      array()
    );
  }
}