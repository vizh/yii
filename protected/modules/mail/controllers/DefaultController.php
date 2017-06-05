<?php

class DefaultController extends \application\components\controllers\AdminMainController
{
    public function actionSend($step = 0)
    {
        set_time_limit(84600);
        error_reporting(E_ALL & ~E_DEPRECATED);

        $template = 'comersant-html-1';
        $isHTML = true;

        $logPath = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
        $fp = fopen($logPath.$template.'.log', "a+");
        $j = 0;

        $criteria = new \CDbCriteria();

        // ГеоВыборка
        /*
        $criteria->with = array(
            'LinkAddress' => array('together' => true, 'select' => false),
            'LinkAddress.Address' => array('together' => true, 'select' => false),
            'LinkAddress.Address.Region' => array('together' => true, 'select' => false),
    //        'LinkAddress.Address.City' => array('together' => true, 'select' => false),
    
            'Participants' => array('together' => true, 'select' => false),
            'Settings' => array('select' => false),
        );
    //    $criteria->addCondition(' ("Participants"."EventId" IN (258) OR "Region"."Id" IN (4925,4503,4773,3761,4481,3503,3251)) AND "Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" = 423)');
    //    $criteria->addCondition('"Region"."Id" IN (4312) AND ( ("Participants"."EventId" = 425 AND "Participants"."RoleId" = 11) OR ("Participants"."EventId" = 422 AND "Participants"."RoleId" = 1) )');
        $criteria->addCondition('"Region"."Id" IN (4312)');
        */

        // Чтение из файла
        $arUsers = file(Yii::getPathOfAlias('webroot').'/files/ext/2014-03-13/emails.csv');
        foreach ($arUsers as $eml) {
            $emails[$eml] = trim($eml);
        }

        /*
        foreach($arUsers as $data) {
          list($name, $eml) = explode(';', $data);
          $emails[$eml] = $name . ';'. trim($eml);
        }
        */

        $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';
//    $emails['ilya.chertilov@gmail.com'] = 'ilya.chertilov@gmail.com';
        /*
            $emails['grebennikov.sergey@gmail.com'] = 'grebennikov.sergey@gmail.com';
            $emails['tatulova@cafe-anderson.ru'] = 'tatulova@cafe-anderson.ru';
            $emails['AHomichuk@okey-dokey.ru'] = 'AHomichuk@okey-dokey.ru';
            $emails['dolzhenko.strana@gmail.com'] = 'dolzhenko.strana@gmail.com';
        */
//    $emails['t.ruzhich@rta-moscow.com'] = 't.ruzhich@rta-moscow.com';
//    $emails['borzov@internetmediaholding.com'] = 'borzov@internetmediaholding.com';
//    $emails['plugotarenko@raec.ru'] = 'plugotarenko@raec.ru';

        $limit = 200;
        $offset = $step * $limit;
        $users = array_slice($emails, $offset, $limit, true);

        print count($emails);
        exit();

        /*
            // C ПОИСКОМ ПО БД
            $criteria->with = array(
              'Settings' => array('select' => false)
            );
            $criteria->addInCondition('"t"."Email"', $emails);
            $criteria->distinct = true;
            $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
            $criteria->addCondition('"t"."Visible"');
        
            echo \user\models\User::model()->count($criteria);
            exit();
        
            $users = \user\models\User::model()->findAll($criteria);
        */
        /*
            // Обычная выборка пользователей [по мероприятиям]
            $criteria->with = array(
              'Participants' => array('together' => true),
              'Participants.Role',
              'Settings' => array('select' => false)
            );
        
        //    $criteria->addInCondition('"Participants"."EventId"', array(870));
        //    $criteria->addInCondition('"Participants"."RoleId"', array(24));
        
        //    $criteria->addCondition('("Participants"."UserId" IN (SELECT "PayerId" FROM "PayOrder" WHERE "EventId" = 787 AND "Paid" = false AND "Juridical" = true AND "Deleted" = false))');
        
            $criteria->distinct = true;
            $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
            $criteria->addCondition('"t"."Visible"');
        
            $criteria->addInCondition('"t"."RunetId"', array(12953));
        //    $criteria->addInCondition('"t"."RunetId"', array(12953, 188122, 184445, 122262));
        
            echo \user\models\User::model()->count($criteria);
            exit();
        
            $criteria->limit = 200;
            $criteria->order = '"t"."RunetId" ASC';
            $criteria->offset = $step * $criteria->limit;
            $users = \user\models\User::model()->findAll($criteria);
        */
        /* Для PK PASS для Яблочников */
//    $event = \event\models\Event::model()->findByPk(837);

        if (!empty($users)) {
            foreach ($users as $user) {
//        list($name, $email) = explode(';', $user);

//        print $user->Participants[0]->Role->Title;
//        print $user->Participants[0]->getTicketUrl();
//        exit();

//        /* PK PASS для Яблочников */
//        $pkPass = new \application\components\utility\PKPassGenerator($event, $user, $user->Participants[0]->Role);

//        $arPromo = array();
//        for($i = 0; $i < 2; $i++) $arPromo[] = $this->getPromo();

                // ПИСЬМО
                $body = $this->renderPartial($template, ['user' => $user], true);
//        $body = $this->renderPartial($template, array('user' => $user, 'arPromo' => $arPromo), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'promo' => $this->getPromo()), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'role' => $user->Participants[0]->Role->Title), true);

                $mail = new \ext\mailer\PHPMailer(false);
                $mail->Mailer = 'mail';
                $mail->ParamOdq = true;
                $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
                $mail->IsHTML($isHTML);

//        $email = $user->Email;
                $email = $user;

                if ($j == 200) {
                    sleep(1);
                    $j = 0;
                };
                $j++;

//        if ($j == 1) continue;

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                /*
                if (preg_match("/@ashmanov.com/i", $email))
                {
                  print 'is @ashmanov.com<br />';
                  continue;
                }
                */

                $mail->AddAddress($email);
                $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
//        $mail->SetFrom('devcon@runet-id.com', 'DevCon 2014', false);
                $mail->CharSet = 'utf-8';
                $mail->Subject = '=?UTF-8?B?'.base64_encode('Закрытый показ фильма «Стартап» в Digital October').'?=';
                $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-12-04/beeline_invite_'.$user->RunetId.'.pdf');

                /* PK PASS для Яблочников */
//        $mail->AddAttachment($pkPass->runAndSave(), 'ticket.pkpass');

//        $mail->Send();

                fwrite($fp, $email."\n");
//        fwrite($fp, $user->RunetId . ' - '. $email . "\n");

            }
            fwrite($fp, "\n\n\n".sizeof($users)."\n\n\n");
            fclose($fp);

            echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/default/send', ['step' => $step + 1]).'"></head><body></body></html>';
//      echo $this->createUrl('/mail/default/send', array('step' => $step+1));
        } else {
            echo 'Рассылка ушла!';
        }
    }

    private function getPromo()
    {
        $coupon = new \pay\models\Coupon();
        $coupon->EventId = 688;
        $coupon->Discount = '0.1';
//    $coupon->ProductId = 1309;
        $coupon->Code = $coupon->generateCode();
        $coupon->Recipient = 'Выдано оплатившему участнику РИФ-2013 и RIW-2013';
        $coupon->save();
        return $coupon->Code;
    }

}
