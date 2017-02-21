<?php
namespace api\controllers\event;

use api\components\Action;
use api\components\Exception;
use event\models\Role;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param as ApiParam;
use nastradamus39\slate\annotations\Action\Sample;

/**
 * Регистрации на мероприяте
 *
 * @param RunetId int участник
 * @param RoleId int идентификатор роли
 * @param UsePriority bool
 *
 */
class RegisterAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Регистрация",
     *     description="Регисрация пользователя на мероприятии с заданной ролью.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/register?RunetId=678047&RoleId=2'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/register",
     *          body="",
     *          params={
     *              @ApiParam(title="RunetId", description="Идентификатор пользователя. Обязательно."),
     *              @ApiParam(title="RoleId", description="Идентификатор статуса, который пользователь должен получить на мероприятии. Обязательно."),
     *          },
     *          response=@Response(body="{'Success': 'true'}")
     *     )
     * )
     */
    public function run()
    {
        $role = Role::model()
            ->findByPk($this->getRequestParam('RoleId'));

        if ($role === null) {
            throw new Exception(302, [$this->getRequestParam('RoleId')]);
        }

        $participant = empty($this->getEvent()->Parts)
            ? $this->getEvent()->registerUser($this->getRequestedUser(), $role, $this->getRequestParamBool('UsePriority', true))
            : $this->getEvent()->registerUserOnAllParts($this->getRequestedUser(), $role);

        if ($participant === null) {
            throw new Exception(303);
        }

        $this->setSuccessResult();
    }
}
