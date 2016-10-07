<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\UserData;
use user\models\User;

class SectionsAction extends Action
{
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('RunetId', null);
        if ($id === null) {
            $id = \Yii::app()->getRequest()->getParam('RocId', null);
        }

        $user = User::model()
            ->byRunetId($id)
            ->find();

        if ($user === null) {
            throw new Exception(202, [$id]);
        }

        $data = $this
            ->getDataBuilder()
            ->createUserSections($user);

        $this->setResult($data);
    }
}