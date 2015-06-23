<?php
namespace api\controllers\iri;

use api\components\Action;
use iri\models\Role;

class RolesAction extends Action
{
    public function run()
    {
        $roles = Role::model()->orderBy('"t"."Id"')->findAll();

        $result = [];
        foreach ($roles as $role) {
            $result[] = $this->getDataBuilder()->createIriRole($role);
        }
        $this->setResult($result);
    }
} 