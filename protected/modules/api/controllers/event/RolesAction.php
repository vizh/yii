<?php
namespace api\controllers\event;

class RolesAction extends \api\components\Action
{
  public function run()
  {
    /** @var $roles \event\models\Role[] */
    $roles = \event\models\Role::model()->findAll();

    $result = array();
    foreach ($roles as $role)
    {
      $result[] = $this->getDataBuilder()->createRole($role);
    }

    $this->setResult($result);
  }
}
