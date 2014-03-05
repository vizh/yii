<?php

class BookingController extends \application\components\controllers\AdminMainController
{
  const EventId = 789;

  public function actions()
  {
    return [
      'index' => '\pay\controllers\admin\booking\IndexAction',
      //'view' => '\pay\controllers\admin\order\ViewAction',
    ];
  }
} 