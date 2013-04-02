<?php
namespace ruvents\controllers\event;

class RolesAction extends \ruvents\components\Action
{
  public function run()
  {
    $event = $this->getEvent();

    $roles = \event\models\Role::model()->byEventId($event->Id)->findAll();
    $result = array('Roles' => array());
    foreach ($roles as $role)
    {
      $result['Roles'][] = $this->getDataBuilder()->createRole($role);
    }
    echo json_encode($result);
  }
}
