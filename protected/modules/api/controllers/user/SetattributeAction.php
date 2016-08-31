<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\UserData;

class SetattributeAction extends Action
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

        $attributeName = \Yii::app()->getRequest()->getParam('AttributeName', '');
        $attributeValue = \Yii::app()->getRequest()->getParam('AttributeValue', '');
        try {
            $userData->getManager()->$attributeName = $attributeValue;
            $userData->save();
        } catch (\application\components\Exception $e) {
            throw new Exception(251, [$e->getMessage()]);
        }

        $this->setSuccessResult();
    }
}