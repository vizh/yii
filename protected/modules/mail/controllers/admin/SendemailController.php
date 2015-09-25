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

        $body = $this->renderPartial('mail.views.templates.template663', [], true);
        $count = 0;

        foreach ($this->emails as $email) {
            /*
            $mail = new TemplateForController($mailer,
                'info@premiaruneta.ru', 'Премия Рунета 2015', $email,
                'Оргкомитет Конкурса «Премии Рунета» открывает прием заявок на соискание XII Национальной премии за вклад в развитие российского сегмента сети Интернет', $body
            );

            //$mail->isTest = true;
            $mail->send();
            //$log = $mail->getLog();
            //$log->save();
            $count++;
            */
        }
        echo 'done: '.$count;
    }
} 