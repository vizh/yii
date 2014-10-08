<?php
use application\components\controllers\AdminMainController;
use mail\components\mail\TemplateForController;

class SendemailController extends AdminMainController
{

    public $emails= [];

    /*public $emails= [


        'info@icamgroup.ru','market@iso.ru','customer@mfms.ru','moscow.office@misys.com',
        'jozsef.bucher@onlinetgroup.com','info@predprocessing.ru','01001010@redmadrobot.com','info-ru@safenet-inc.com',
        'Ru.ccc@schneider-electric.com','info@terrasoft.ru','info@tim-connect.сom','sales@wsoft.ru','info@rutoken.ru','root@bssys.com',
        'info@bis.ru','resp@gaz-is.ru','info@stack-kazan.net','info@diasoft.ru','mail@inversion.ru','info@infosysco.ru','info@iters.ru',
        'office@quadrium.ru','mail@lnc.ru','info@neoflex.ru','inform@athena.ru','DM@otr.ru','info@programbank.ru','marketing@rdtex.ru',
        'info@certsys.ru','pr@cinimex.ru','info@tsconsulting.ru','info@flexsoft.com','hotline@unisab.ru',];*/


    /*public $emails= ['info@isimplelab.com', 'post@id-sys.ru', 'info@icamgroup.ru', 'Moscow@cft.ru', 'info@bis.ru',
        'pr@diasoft.ru', 'info@bifit.com', 'info@cinimex.ru', 'info@flexsoft.com','sales@arqa.ru', 'clients@at-consulting.ru',
        'info@comparex.ru', 'info@CranePI.com','info.ru@crif.com','Info@aflex.ru','contact@dzcard.com','info@goswiff.com',
        'info@icamgroup.ru','info@idamob.ru','ru_sales@infobip.com','market@iso.ru','customer@mfms.ru','moscow.office@misys.com',
        'jozsef.bucher@onlinetgroup.com','info@predprocessing.ru','01001010@redmadrobot.com','info-ru@safenet-inc.com',
        'Ru.ccc@schneider-electric.com','info@terrasoft.ru','info@tim-connect.сom','sales@wsoft.ru','info@rutoken.ru','root@bssys.com',
        'info@bis.ru','resp@gaz-is.ru','info@stack-kazan.net','info@diasoft.ru','mail@inversion.ru','info@infosysco.ru','info@iters.ru',
        'office@quadrium.ru','mail@lnc.ru','info@neoflex.ru','inform@athena.ru','DM@otr.ru','info@programbank.ru','marketing@rdtex.ru',
        'info@certsys.ru','pr@cinimex.ru','info@tsconsulting.ru','info@flexsoft.com','hotline@unisab.ru',];*/

    public function actionIndex()
    {
        echo '123';
    }

    public function actionSend()
    {
        $mailer = new \mail\components\mailers\MandrillMailer();

        $body = $this->renderPartial('mail-1', [], true);

        foreach ($this->emails as $email) {
            $mail = new TemplateForController($mailer,
                'partners@russianinternetweek.ru', 'RIW 2014', $email,
                'Приглашаем к участию в Russian Interactive Week (12-14 ноября)', $body
            );
            $mail->isTest = true;
            $mail->send();

            $log = $mail->getLog();
            $log->save();
        }
        echo 'done';
    }
} 