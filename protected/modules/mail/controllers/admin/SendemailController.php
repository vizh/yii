<?php
use application\components\controllers\AdminMainController;
use mail\components\mail\TemplateForController;

class SendemailController extends AdminMainController
{
    public $emails = [];

    public function actionIndex()
    {
        echo '123';
    }

    public function actionSend()
    {
        $mailer = new \mail\components\mailers\MandrillMailer();

        $body = $this->renderPartial('mail.views.templates.template799', [], true);
        $count = 0;

        foreach ($this->emails as $email) {

            $mail = new TemplateForController($mailer,
                'event@ruvents.com', 'RUVENTS', $email,
                'Быстрая и технологичная регистрация и аккредитация участников.', $body
            );

            //$mail->isTest = true;
            //$mail->send();
            $count++;
        }
        echo 'done: '.$count;
    }
} 