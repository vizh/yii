<?php


class EventController extends ruvents\components\Controller
{

  public function actions()
  {
    return array(
      'users' => 'ruvents\controllers\event\UsersAction',
      'register' => 'ruvents\controllers\event\RegisterAction',
      'unregister' => 'ruvents\controllers\event\UnregisterAction',
      'roles' => 'ruvents\controllers\event\RolesAction',
      'badge' => 'ruvents\controllers\event\BadgeAction',
    );
  }
}
