<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\UserData;

class SetdataAction extends Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null)
            throw new Exception(202, [$runetId]);

        $userData = new UserData();
        $userData->EventId = $this->getEvent()->Id;
        $userData->UserId = $user->Id;

        $attributes = \Yii::app()->getRequest()->getParam('Attributes', []);
        try {
            foreach ($attributes as $key => $value) {
                $userData->getManager()->$key = $value;
            }
            $userData->save();
        } catch (\application\components\Exception $e) {
            throw new Exception(251, [$e->getMessage()]);
        }

        $this->setResult(['Success' => true]);
    }
} 