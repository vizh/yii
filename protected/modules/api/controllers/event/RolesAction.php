<?php
namespace api\controllers\event;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class RolesAction extends Action
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
