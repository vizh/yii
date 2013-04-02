<?php


class EventController extends ruvents\components\Controller
{

  public function actions()
  {
    return array(
      'users' => 'ruvents\controllers\event\UsersAction',
      'register' => 'ruvents\controllers\event\RegisterAction',
      'unregister' => 'ruvents\controllers\event\UnregisterAction',
      'changerole' => 'ruvents\controllers\event\ChangeroleAction',
      'roles' => 'ruvents\controllers\event\RolesAction',
      'settings' => 'ruvents\controllers\event\SettingsAction',
    );
  }
}
