<?php
namespace api\controllers\user;

use api\components\Exception;
use api\models\forms\user\Edit;
use event\models\Participant;
use oauth\models\Permission;
use user\models\User;

class EditAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $id = $request->getParam('RunetId');

        $user = User::model()->byRunetId($id)->find();
        if (empty($user)) {
            throw new Exception(202, [$id]);
        }

        $permission = Permission::model()->byUserId($user->Id)->byAccountId($this->getAccount()->Id)->find();
        $participant = Participant::model()->byEventId($this->getAccount()->EventId)->byUserId($user->Id)->find();
        if (empty($permission) || empty($participant)) {
            throw new Exception(230, [$user->RunetId]);
        }

        $form = new Edit($user);
        $form->fillFromPost();
        $form->updateActiveRecord();
        $this->setResult(['Success' => true]);
    }
} 