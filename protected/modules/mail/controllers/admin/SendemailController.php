<?php
use application\components\controllers\AdminMainController;
use mail\components\mail\TemplateForController;

class SendemailController extends AdminMainController
{

    public $emails= [];

    public function actionIndex()
    {
        echo '123';
    }

    public function actionSend()
    {
        $mailer = new \mail\components\mailers\MandrillMailer();

        $body = $this->renderPartial('mail-1', [], true);
        $count = 0;

        foreach ($this->emails as $email) {
            $mail = new TemplateForController($mailer,
                'info@news.leroymerlin.ru', 'Leroy Merlin', $email,
                'Приглашение на конференцию "Стратегия развития Леруа Мерлен"', $body
            );
            //$mail->isTest = true;
            //$mail->send();
            //$log = $mail->getLog();
            //$log->save();
            $count++;
        }
        echo 'done: '.$count;
    }
} 