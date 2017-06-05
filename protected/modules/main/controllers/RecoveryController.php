<?php

class RecoveryController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($runetId, $hash)
    {
        $user = user\models\User::model()->byRunetId($runetId)->find();
        if ($user !== null && $user->checkRecoveryHash($hash)) {
            $mail = new \ext\mailer\PHPMailer(false);
            $mail->AddAddress($user->Email);
            $mail->SetFrom('users@'.RUNETID_HOST, \Yii::t('app', 'RUNET-ID'), false);
            $mail->CharSet = 'utf-8';
            $mail->Subject = '=?UTF-8?B?'.base64_encode(\Yii::t('app', 'Восстановление пароля')).'?=';
            $mail->IsHTML(true);
            $password = $user->changePassword();
            $mail->MsgHTML(
                \Yii::app()->controller->renderPartial('user.views.mail.recover', ['user' => $user, 'type' => 'withPassword', 'password' => $password], true)
            );
            $mail->Send();
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
