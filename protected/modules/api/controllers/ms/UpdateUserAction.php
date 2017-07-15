<?php

namespace api\controllers\ms;

use api\components\Action;
use api\components\Exception;
use api\components\ms\forms\UpdateUser;
use user\models\User;
use Yii;

class UpdateUserAction extends Action
{
    public function run()
    {
        $id = Yii::app()->getRequest()->getParam('RunetId');
        $user = User::model()->byEventId($this->getAccount()->EventId)->byRunetId($id)->find();
        if ($user === null) {
            throw new Exception(202, [$id]);
        }

        $form = new UpdateUser($user, $this->getAccount());
        $form->fillFromPost();
        if ($form->updateActiveRecord() !== null) {
            $this->setSuccessResult();
        }
    }
}
