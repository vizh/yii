<?php
class RifordersController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'rif13-2';
    $isHTML = false;

//    exit();

    $logPath = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $fp = fopen($logPath.$template.'.log',"a+");
    $j = 0;

    $criteria = new \CDbCriteria();

    $criteria->with = array(
      'ItemLinks.OrderItem' => array('together' => true),
    );
    $criteria->addCondition('NOT "t"."Paid"');
    $criteria->addCondition('NOT "t"."Deleted"');
    $criteria->addCondition('"t"."EventId" = :EventId');
    $criteria->addCondition('"t"."Juridical"');
    $criteria->addCondition('"OrderItem"."Booked" IS NOT NULL');
    $criteria->addCondition('"OrderItem"."Booked" < :Booked');

//    $criteria->addCondition('"t"."PayerId" = 12099');

    $criteria->params = array(
      ':EventId' => 422,
      ':Booked' => '2013-03-29 00:00:00'
    );

    $orders = \pay\models\Order::model()->findAll($criteria);

    print count($orders);
    exit();

    if (!empty($orders))
    {
      foreach ($orders as $order)
      {
        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $order->Payer, 'order' => $order, 'regLink' => $this->getRegLink($order->Payer)), true);
        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);

        if ($order->Payer->getContactEmail() !== null)
        {
          $email = $order->Payer->getContactEmail()->Email;
        }
        else
        {
          $email = $order->Payer->Email;
        }

        if ($j == 300) { sleep(1); $j = 0; }; $j++;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          continue;
        }

        $mail->AddAddress($email);
        $mail->SetFrom('users@rif.ru', 'Служба поддержки участников РИФ+КИБ 2013', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Истекает срок брони номера на РИФ+КИБ 2013') .'?=';
        $mail->Body = $body;
        $mail->Send();

        fwrite($fp, $order->Payer->RunetId.'-'.$email."\n");
      }
      fwrite($fp, "\n\n\n" . sizeof($orders) . "\n\n\n");
      fclose($fp);
//      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/riforders/send', array('step' => $step+1)).'"></head><body></body></html>';
    }
    else
    {
      echo 'Рассылка ушла!';
    }
  }

  private function getRegLink($user)
  {
    $secret = 'vyeavbdanfivabfdeypwgruqe'; // common

    $timestamp = time();
    $runetid = $user->RunetId;

    $hash = substr(md5($runetid . $secret . $timestamp), 0, 8);
    return 'http://2013.russianinternetforum.ru/'.$runetid.'/'.$hash;
  }

}
