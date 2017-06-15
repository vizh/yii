<?php

class RecoveryController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($runetId, $hash)
    {
        $user = user\models\User::model()->byRunetId($runetId)->find();
        if ($user !== null && $user->checkRecoveryHash($hash)) {
            $mail = new PHPMailer(false);
            $mail->addAddress($user->Email);
            $mail->setFrom('users@'.RUNETID_HOST, \Yii::t('app', 'RUNET-ID'), false);
            $mail->CharSet = 'utf-8';
            $mail->Subject = '=?UTF-8?B?'.base64_encode(\Yii::t('app', 'Восстановление пароля')).'?=';
            $mail->isHTML();
            $password = $user->changePassword();
            $mail->msgHTML(
                \Yii::app()->controller->renderPartial('user.views.mail.recover', ['user' => $user, 'type' => 'withPassword', 'password' => $password], true)
            );
            $mail->send();
            $identity = new \application\components\auth\identity\RunetId($user->RunetId);
            $identity->authenticate();
            \Yii::app()->user->login($identity);
            $this->redirect($this->createUrl('/main/default/index'));
        } else {
            \Yii::app()->user->setFlash('error', \Yii::t('app', 'Ссылка на восстановления пароля устарела.'));
            $this->render('index');
        }
    }
}
