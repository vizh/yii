<?php

class UnsubscribeController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($email, $hash)
    {
        $users = \user\models\User::model()->byEmail($email)->findAll();
        if (empty($users)) {
            throw new CHttpException(500, 'Не найден пользователь с email: ' . $email);
        }

        /** @var \user\models\User $user */
        foreach ($users as $user)
        {
            if ($user->getHash() == $hash) {
                $user->Settings->UnsubscribeAll = true;
                $user->Settings->save();
                $this->setPageTitle(\Yii::t('app', 'Подписка успешно отменена'));
                $this->render('index');
                return;
            }
        }

        throw new \CHttpException(500, 'Не корректный код отписки пользователя. Пришедший код: ' . $hash . ' Email пользователя: ' . $email);
    }
}
