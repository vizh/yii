<?php
namespace api\controllers\event;

use api\components\Action;
use api\components\Exception;
use event\models\Role;

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
