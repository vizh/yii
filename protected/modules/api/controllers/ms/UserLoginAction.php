<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\builders\Builder;
use api\components\Exception;
use api\components\ms\Helper;
use api\components\ms\mail\AuthCode;
use mail\components\mailers\SESMailer;
use user\models\User;
use Yii;

class UserLoginAction extends Action
{
    public function run()
    {
        $request = Yii::app()->getRequest();
        $email = $request->getParam('Email');
        $password = base64_decode($request->getParam('Password'));

        $user = User::model()
            ->byEventId($this->getAccount()->EventId)
            ->byEmail($email)
            ->find();

        if ($user === null) {
            throw new Exception(211, [$email]);
        }

        if (!$user->checkLogin($password)) {
            throw new Exception(201);
        }

        $userData = $this->getDataBuilder()->createUser($user, [
            Builder::USER_PERSON,
            Builder::USER_PHOTO,
            Builder::USER_EMPLOYMENT,
            Builder::USER_EVENT,
            Builder::USER_AUTH
        ]);

        $mail = new AuthCode(new SESMailer(), $user, $userData->AuthCode);
        $mail->send();

        $this->setResult($userData);
    }
}
