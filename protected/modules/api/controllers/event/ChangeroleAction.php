<?php
namespace api\controllers\event;

use api\components\Exception;
use event\models\Participant;

/**
 * Изменение статуса на мероприятии
 * параметры: RunetId -участник RoleId - id новой роли
 * Class ChangeroleAction
 * @package api\controllers\event
 */
class ChangeroleAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');

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

        $participant = Participant::model()
            ->byUserId($user->Id)
            ->byEventId($this->getEvent()->Id)
            ->find();
        if (empty($participant))
        {
            throw new Exception(302, [$participant]);
        }

        $participant->RoleId = $roleId;
        if($participant->save()){
            $this->setResult(array('Success' => true));
        } else {
            $this->setResult(array('Error' => true));
        }
    }
}