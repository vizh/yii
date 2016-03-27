<?php
namespace ruvents\controllers\event;

use event\models\Role;
use ruvents\components\Exception;
use user\models\User;

class RegisterAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        $roleId = $request->getParam('RoleId', null);
        $partId = $request->getParam('PartId', null);

        $event = $this->getEvent();

        $user = User::model()
            ->byRunetId($runetId)
            ->find();

        if ($user === null)
            throw new Exception(202, $runetId);

        /** @var $role Role */
        $role = Role::model()
            ->findByPk($roleId);

        if ($role === null)
            throw new Exception(302, $roleId);

        $part = null;

        try {
            if (count($event->Parts) > 0) {
//        $part = \event\models\Part::model()->findByPk($partId);
//        if ($part === null)
//        {
//          throw new \ruvents\components\Exception(306, array($partId));
//        }
//        $event->registerUserOnPart($part, $user, $role);
                $event->registerUserOnAllParts($user, $role);
            } else {
                $event->registerUser($user, $role);
            }
        } catch (\Exception $e) {
            throw new Exception(100, $e->getMessage());
        }

        $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Role', 0, $role->Id));
        if ($part !== null) {
            $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Part', $part->Id, $part->Id));
        }
        $this->getDetailLog()->UserId = $user->Id;
        $this->getDetailLog()->save();

        echo json_encode(['Success' => true]);
    }
}
