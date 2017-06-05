<?php

class FastregisterController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($runetId, $eventIdName, $roleId, $hash, $redirectUrl = '')
    {
        $user = user\models\User::model()->byRunetId($runetId)->find();
        $event = \event\models\Event::model()->byIdName($eventIdName)->find();
        $role = \event\models\Role::model()->findByPk($roleId);

        if ($user == null || $event == null || $role == null || $hash != $event->getFastRegisterHash($user, $role)) {
            throw new \CHttpException(404);
        }

        $identity = new \application\components\auth\identity\RunetId($user->RunetId);
        $identity->authenticate();
        if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
            if (!$user->Temporary) {
                \Yii::app()->user->login($identity);
            } else {
                if (!\Yii::app()->user->isGuest) {
                    \Yii::app()->user->logout();
                }
                \Yii::app()->tempUser->login($identity);
            }

            if (empty($event->Parts)) {
                $event->registerUser($user, $role, true);
            } else {
                $event->registerUserOnAllParts($user, $role, true);
            }

            if (!empty($redirectUrl)) {
                if (strpos($redirectUrl, '/') !== false) {
                    $this->redirect($redirectUrl);
                } else {
                    $shortUrl = \main\models\ShortUrl::model()->byHash($redirectUrl)->find();
                    if ($shortUrl !== null) {
                        $this->redirect($shortUrl->Url);
                    }
                }
            }
            $this->redirect($event->getUrl());
        }
    }
} 