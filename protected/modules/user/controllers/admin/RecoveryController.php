<?php

use user\models\User;
use user\components\handlers\recover\mail\AdminRecover;
use mail\components\mailers\SESMailer;

class RecoveryController extends \application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $request = \Yii::app()->getRequest();
        if ($request->isPostRequest) {
            $runetId = $request->getParam('RunetId');
            $user = User::model()->byRunetId($runetId)->find();
            $password = uniqid();
            $user->changePassword($password);
            if ($user == null) {
                \Yii::app()->user->setFlash('error', \Yii::t('app', 'Пользователь с таким RUNET&ndash;ID не найден.'));
            } else {
                $mail = new AdminRecover(new SESMailer(), $user, $password);
                $mail->send();
                Yii::app()->user->setFlash('success', Yii::t('app', 'На указанный адрес электронной почты было отправлено письмо с новым паролем.'));
            }
        }
        $this->render('index');
    }
}
