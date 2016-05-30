<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\ms\Helper;
use api\components\ms\mail\AuthCode;
use application\components\utility\Texts;
use mail\components\mailers\SESMailer;
use user\models\User;
use api\components\Exception;

class UserLoginAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $email = $request->getParam('Email');
        $password = base64_decode($request->getParam('Password'));

        $user = User::model()->byEventId($this->getAccount()->EventId)->byEmail($email)->find();
        if ($user === null) {
            throw new Exception(211, [$email]);
        }

        if (!$user->checkLogin($password)) {
            throw new Exception(201);
        }

        $builder = $this->getDataBuilder();
        $builder->createUser($user);
        $builder->buildUserEmployment($user);
        $data = $builder->buildUserEvent($user);

        $data->AuthCode = Texts::GenerateString(10);

        $mail = new AuthCode(new SESMailer(), $user, $data->AuthCode);
        $mail->send();

        $this->setResult($data);
    }
}
