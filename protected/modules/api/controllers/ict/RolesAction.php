<?php

namespace api\controllers\ict;

use api\components\Action;
use ict\models\Role;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class RolesAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Ict",
     *     title="Роли ICT",
     *     description="Возвращает список ролей для ICT",
     *     request=@Request(
     *          method="GET",
     *          url="/ict/roles",
     *          params={},
     *          response=@Response(body="")
     *     )
     * )
     */
    public function run()
    {
        $roles = Role::model()->orderBy('"t"."Id"')->findAll();

        $result = [];
        foreach ($roles as $role) {
            $result[] = $this->getDataBuilder()->createIctRole($role);
        }
        $this->setResult($result);
    }
}
