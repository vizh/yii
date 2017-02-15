<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class RolesAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Статусы",
     *     description="Список статусов.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/roles",
     *          response=@Response(body="['Объект EVENTROLE']")
     *     )
     * )
     */
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
