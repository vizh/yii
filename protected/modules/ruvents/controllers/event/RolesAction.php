<?php
namespace ruvents\controllers\event;

use event\models\Role;

class RolesAction extends \ruvents\components\Action
{
  public function run()
  {
    $roles = $this->getEvent()->getRoles();
    $response = [];

    foreach ($roles as $role)
      $response[] = $this->getDataBuilder()->createRole($role);

    $this->renderJson([
      'Roles' => $response
    ]);
  }
}