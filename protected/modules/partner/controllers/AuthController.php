<?php

use partner\components\Identity;

class AuthController extends partner\components\Controller
{
    public function actionIndex()
    {
        $request = Yii::app()->getRequest();
        $errorMessage = null;

        $login = $request->getParam('login');

        if ($request->getIsPostRequest()) {
            $password = $request->getParam('password');

            $identity = new Identity($login, $password);
            $identity->authenticate();

            if ($identity->errorCode === Identity::ERROR_NONE) {
                Yii::app()->partner->login($identity);
                $backUrl = $request->getParam('backUrl');
                $this->redirect(empty($backUrl)
                    ? Yii::app()->createUrl('/partner/main/home')
                    : $backUrl
                );
            }

            $errorMessage = $identity->errorMessage;
        }

        if (!Yii::app()->partner->isGuest) {
            Yii::app()->partner->logout();
            $this->refresh();
        }

        $this->render('index', [
            'login' => $login,
            'errorMessage' => $errorMessage
        ]);
    }

    public function actionLogout($extended = null)
    {
        if ($extended === 'reset' && Yii::app()->partner->getAccount()->getIsExtended()) {
            Yii::app()->getSession()->remove('PartnerAccountEventId');
        } else {
            Yii::app()->partner->logout(false);
        }

        $this->redirect(Yii::app()->createUrl('/partner/main/index'));
    }
}