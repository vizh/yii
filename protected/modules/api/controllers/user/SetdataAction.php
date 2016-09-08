<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\UserData;
use Yii;

class SetdataAction extends Action
{
    public function run()
    {
        $userData = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->byUserId($this->getRequestedUser()->Id)
            ->orderBy(['"t"."CreationTime"'])
            ->find();


        if ($userData === null)
            $userData = UserData::createEmpty(
                $this->getEvent(),
                $this->getRequestedUser()
            );

        $manager = $userData->getManager();

        if (!$manager->getDefinitions())
            throw new Exception(251, ['На данном мероприятии отсутствуют определения пользовательских атрибутов']);

        try {
            foreach (Yii::app()->getRequest()->getParam('Attributes', []) as $param => $value) {
                if (!isset($manager->$param) || $manager->$param !== $value)
                    $manager->$param = $value;
            }
        } catch (Exception $e) {
            throw new Exception(251, [$e->getMessage()]);
        }

        if (!$manager->validate())
            foreach ($manager->getErrors() as $attribute => $errors)
                throw new Exception(252, [$attribute, $errors[0]]);

        $userData->save();

        $this->setSuccessResult();
    }
}