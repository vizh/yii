<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class RolesAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Роли",
     *     description="Список возможных ролей участника мероприятия.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/roles'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/roles",
     *          response=@Response(body="['{$EVENTROLE}']")
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
