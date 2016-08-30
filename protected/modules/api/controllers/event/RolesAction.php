<?php
namespace api\controllers\event;

class RolesAction extends \api\components\Action
{
    public function run()
    {
        $roles = $this
            ->getEvent()
            ->getRoles();


        $result = [];
        foreach ($roles as $role) {
            $result[] = $this->getDataBuilder()->createRole($role);
        }

        $this->setResult($result);
    }
}
