<?php
namespace ruvents\controllers\event;

use event\models\Role;

class RolesAction extends \ruvents\components\Action
{
  public function run()
  {
    $event = $this->getEvent();
    $roles = Role::model()->byEventId($event->Id)->findAll();
    $response = [];

    foreach ($roles as $role)
      $response[] = $this->getDataBuilder()->createRole($role);

    $this->renderJson([
      'Roles' => $response
    ]);
  }
}
