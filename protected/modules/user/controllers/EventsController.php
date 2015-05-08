<?php


class EventsController extends \application\components\controllers\PublicMainController
{
  public $bodyId = 'user-events';

  public function actions()
  {
    return [
      'index' => 'user\controllers\events\IndexAction',
      'orders' => 'user\controllers\events\OrdersAction',
    ];
  }

}
