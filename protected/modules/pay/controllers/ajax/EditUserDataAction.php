<?php
namespace pay\controllers\ajax;

use event\models\UserData;

class EditUserDataAction extends \pay\components\Action
{
    public function run($eventIdName, $runetId)
    {
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new \CHttpException(404);
        }

        $earlyUserDataModels = UserData::model()
            ->byUserId($user->Id)->byEventId($this->getEvent()->Id)
            ->findAll(['order' => 't."CreationTime" DESC']);

        $userData = new UserData();
        $userData->EventId = $this->getEvent()->Id;
        $userData->UserId = $user->Id;
        $userData->CreatorId = $this->getUser()->Id;
        $dataManager = $userData->getManager();
        $dataManager->setAttributes(\Yii::app()->getRequest()->getParam(get_class($dataManager)));

        $result = new \stdClass();
        $result->success = true;
        if (count($earlyUserDataModels) > 0) {
            if ($this->hasNewValues($userData, $earlyUserDataModels)) {
                $userData->save(false);
            }
        } elseif ($dataManager->validate()) {
            $userData->save();
        } else {
            $result->success = false;
            $result->errors = $dataManager->getErrors();
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Возвращает true, если по одному из аттрибутов первое не пустое значение не совпадает с текущим
     * @param UserData $userData
     * @param UserData[] $earlyUserDataModels
     * @return bool
     */
    private function hasNewValues($userData, $earlyUserDataModels)
    {
        foreach ($userData->getManager()->getDefinitions() as $name => $definition) {
            $value = $userData->getManager()->{$name};
            if (empty($value)) {
                continue;
            }
            foreach ($earlyUserDataModels as $earlyUserData) {
                $value2 = $earlyUserData->getManager()->{$name};
                if (!empty($value2)) {
                    if ($value2 !== $definition->typecast($value)) {
                        return true;
                    } else {
                        break;
                    }
                }
            }
        }
        return false;
    }
} 