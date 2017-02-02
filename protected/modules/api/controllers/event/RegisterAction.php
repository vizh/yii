<?php
namespace api\controllers\event;

use api\components\Action;
use api\components\Exception;
use event\models\Role;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

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
     *     title="Изменение статуса",
     *     description="Изменение статуса пользователя (или добавление).",
     *     request=@Request(
     *          method="GET",
     *          url="/event/register",
     *          body="",
     *          params={
     *              @Param(title="RunetId", type="", defaultValue="", description="Идентификатор пользователя. Обязательно. "),
     *              @Param(title="RoleId", type="", defaultValue="", description="Идентификатор статуса, который пользователь должен получить на мероприятии. Обязательно. "),
     *          },
     *          response="{
    'Success': 'true'
}"
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
