<?php
namespace api\controllers\event;

use api\components\Exception;

/**
 * Функция регистрации на мероприяте
 * параметры: RunetId -участник RoleId - id роли
 * Class RegisterAction
 * @package api\controllers\event
 */
class RegisterAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');
        $usePriority = $request->getParam('UsePriority', true);

        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if (empty($user))
        {
            throw new Exception(202, [$runetId]);
        }

        $role = \event\models\Role::model()->findByPk($roleId);
        if (empty($role))
        {
            throw new Exception(302, [$roleId]);
        }

        try{
            if (empty($this->getEvent()->Parts))
            {
                $participant = $this->getEvent()->registerUser($user, $role, $usePriority);
            }
            else
            {
                $participant = $this->getEvent()->registerUserOnAllParts($user, $role);
            }
        }
        catch(\Exception $e)
        {
            throw new Exception(100, [$e->getMessage()]);
        }
        if (empty($participant))
        {
            throw new Exception(303);
        }

        $this->setResult(array('Success' => true));
    }
}
