<?php
namespace api\controllers\user;

use api\components\Exception;
use event\models\Participant;
use oauth\models\Permission;

class EditAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null)
            throw new Exception(202, [$runetId]);

        $permissionModel = Permission::model()->byUserId($user->Id)->byAccountId($this->getAccount()->Id)
            ->byDeleted(false);
        $participant = Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id);
        if ($participant->exists() || $permissionModel->exists() || $this->getAccount()->Role == 'own') {
            $phone = $request->getParam('Phone', null);
            if (!empty($phone)) {
                $user->setContactPhone($phone);
            }
            $this->setResult(['Success' => true]);
        } else {
            throw new Exception(230, [$runetId]);
        }
    }
} 