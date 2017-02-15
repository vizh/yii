<?php
namespace api\controllers\iri;

use api\components\Action;
use iri\models\Role;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class RolesAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Iri",
     *     title="Роли ИРИ",
     *     description="Возвращает список ролей для ИРИ",
     *     request=@Request(
     *          method="GET",
     *          url="/iri/roles",
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
            $result[] = $this->getDataBuilder()->createIriRole($role);
        }
        $this->setResult($result);
    }
} 