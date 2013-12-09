<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'descamp13-html-1';
    $isHTML = true;

    $logPath = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $fp = fopen($logPath.$template.'.log',"a+");
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
    $criteria->addCondition('"Region"."Id" IN (4312)');
*/

    // Чтение из файла
/*
//    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-11-26/alley_all.csv');
//    foreach($arUsers as $eml) $emails[$eml] = trim($eml);
    $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';
//    $emails['ilya.chertilov@gmail.com'] = 'ilya.chertilov@gmail.com';
//    $emails['t.ruzhich@rta-moscow.com'] = 't.ruzhich@rta-moscow.com';
//    $emails['grebennikov.sergey@gmail.com'] = 'grebennikov.sergey@gmail.com';
//    $emails['borzov@internetmediaholding.com'] = 'borzov@internetmediaholding.com';
//    $emails['plugotarenko@raec.ru'] = 'plugotarenko@raec.ru';

    $limit = 300;
    $offset = $step * $limit;
    $users = array_slice($emails, $offset, $limit, true);

//    print count($emails); exit();
*/

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

    // Обычная выборка пользователей [по мероприятиям]
    $criteria->with = array(
      'Participants' => array('together' => true),
      'Participants.Role',
      'Settings' => array('select' => false)
    );

//    $criteria->addInCondition('"Participants"."EventId"', array(844));
    $criteria->addInCondition('"Participants"."EventId"', array(794));

    $criteria->addInCondition('"Participants"."RoleId"', array(24));
//    $criteria->addInCondition('"Participants"."PartId"', array(19));

//    $criteria->addCondition('"Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "RoleId" != 24 AND "EventId" = 688)');

    $criteria->distinct = true;
//    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
//    $criteria->addCondition('"t"."Visible"');

//    $criteria->addInCondition('"t"."RunetId"', array(184399, 185239));
//    $criteria->addInCondition('"t"."RunetId"', array(12953/*,59999/*,185212,185213*/));

    echo \user\models\User::model()->count($criteria);
    exit();

    $criteria->limit = 300;
    $criteria->order = '"t"."RunetId" ASC';
    $criteria->offset = $step * $criteria->limit;
    $users = \user\models\User::model()->findAll($criteria);

    /* Для PK PASS для Яблочников */
//    $event = \event\models\Event::model()->findByPk(688);

    if (!empty($users))
    {
      foreach ($users as $user)
      {

//        $this->genBeePDF($user);

//        print $user->Participants[0]->Role->Title;
//        print $user->Participants[0]->getTicketUrl();
//        exit();

//        /* PK PASS для Яблочников */
//        $pkPass = new \application\components\utility\PKPassGenerator($event, $user, $role);

//        $arPromo = array();
//        for($i = 0; $i < 2; $i++) $arPromo[] = $this->getPromo();

        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $user), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'arPromo' => $arPromo), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user)), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'promo' => $this->getPromo()), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'role' => $user->Participants[0]->Role->Title), true);

        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);

        $email = $user->Email;
//        $email = $user;

        if ($j == 300) { sleep(1); $j = 0; }; $j++;

//        if ($j == 1) continue;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
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
//        $mail->SetFrom('ux2013@userexperience.ru', 'Userexperience 2013', false);
//        $mail->SetFrom('experts@premiaruneta.ru', 'Премия Рунета 2013', false);
//        $mail->SetFrom('info@russiandigitalgames.ru', 'Russian Digital Games 2013', false);
//        $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
//        $mail->SetFrom('reg@ibcrussia.com', 'IBC Russia 2013', false);
        $mail->SetFrom('event@runet-id.com', 'Design Camp', false);

//        $mail->SetFrom('New_Year@beeline.ru', 'Beeline', false);
//        $mail->SetFrom('Vova@beeline.ru', 'Beeline', false);

        $mail->CharSet = 'utf-8';
//        $mail->Subject = '=?UTF-8?B?'. base64_encode('Приглашение на Новый год для лучших сотрудников') .'?=';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Осталось 3 дня, чтобы купить билет!') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-12-04/beeline_invite_'.$user->RunetId.'.pdf');

        /* PK PASS для Яблочников */
//        $mail->AddAttachment($pkPass->runAndSave(), 'ticket.pkpass');

//        $mail->Send();

//        fwrite($fp, $email . "\n");
        fwrite($fp, $user->RunetId . ' - '. $email . "\n");
      }
      fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");
      fclose($fp);

      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/default/send', array('step' => $step+1)).'"></head><body></body></html>';
//      echo $this->createUrl('/mail/default/send', array('step' => $step+1));
    }
    else
    {
      echo 'Рассылка ушла!';
    }
  }

  private function genBeePDF($user)
  {
    ob_start();
    ?>
    <page backimg="http://runet-id.com/img/event/beesuper13/bee_pdf_bg.jpg">
      <div style="text-align: center; position: absolute; bottom: 75mm; right: -3mm;"><img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user,100);?>" /><br/><?=$user->RunetId;?></div>
    </page>
    <?
    $content = ob_get_clean();

    require_once(\Yii::getPathOfAlias('ext.html2pdf.html2pdf').'.php');
    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-12-04/beeline_invite_'.$user->RunetId.'.pdf', 'F');
  }

  private function getRegLink($user)
  {
    $runetId = $user->RunetId;
    $secret = 'xggMpIQINvHqR0QlZgZa';

   	$hash = substr(md5($runetId.$secret), 0, 16);

//    return 'http://ibcrussia.com/my/'.$runetId.'/'.$hash.'/';
    return 'http://2013.russianinternetweek.ru/my/'.$runetId.'/'.$hash.'/?redirect=/vote/';
//    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/?redirect=/vote/';
  }

  private function getWaybillLink($user)
  {
    $runetId = $user->RunetId;
    $secret = 'xggMpIQINvHqR0QlZgZa';

   	$hash = substr(md5($runetId.$secret), 0, 16);

//    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/';
    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/?redirect=/my/waybill.php';
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
