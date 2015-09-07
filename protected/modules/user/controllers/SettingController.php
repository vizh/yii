<?php

use application\components\controllers\PublicMainController;

class SettingController extends PublicMainController
{
    public function actions()
    {
        return [
            'password' => '\user\controllers\setting\PasswordAction',
            'indexing' => '\user\controllers\setting\IndexingAction',
            'subscription' => '\user\controllers\setting\SubscriptionAction',
            'connect' => '\user\controllers\setting\ConnectAction',
        ];
    }

    /**
     * Подтверждение аккаунта пользователя
     */
    public function actionVerify()
    {
        $user = \Yii::app()->getUser()->getCurrentUser();
        if ($user->Verified) {
            $this->redirect(['/main/default/index']);
        }

        $user->Verified = true;
        $user->save();
        $this->render('verify', ['user' => $user]);
    }
}
