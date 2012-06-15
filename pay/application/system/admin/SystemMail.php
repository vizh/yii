<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.mail.*');

class SystemMail extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $day = 24*60*60;
    $time = time()+$day;
    $start = date('Y-m-d', $time) . ' 09:00:00';

    while(intval(date('N', $time)) >= 6)
    {
      $time += $day;
    }
    $time += $day;
    $end = date('Y-m-d', $time) . ' 09:00:00';

    echo $start . ' - ' . $end . '<br>';


    $criteria = new CDbCriteria();
    $criteria->condition = 't.Booked IS NOT NULL AND t.Paid = :Paid
      AND t.PaidTime IS NOT NULL AND t.Deleted = :Deleted
      AND t.Booked > :BookedStart AND t.Booked < :BookedEnd';
    $criteria->params = array(':Paid' => 0, ':Deleted' => 0, ':BookedStart' => $start, ':BookedEnd' => $end);

    $items = OrderItem::model()->with('Payer')->findAll($criteria);

    foreach ($items as $item)
    {
      $this->SendMail($item, '1-day-report');
    }

    $item = new OrderItem();
    $item->PayerId = 34528;
    $item->Booked = '2012-04-02 23:59:59';
    $this->SendMail($item, '1-day-report');

    echo sizeof($items);
  }

  /**
   * @param OrderItem $item
   * @param string $template
   * @param bool $isHTML
   */
  protected function SendMail($item, $template, $isHTML = false)
  {
    $user = $item->Payer;

    $mailView = new View();
    $mailView->SetTemplate($template);

    $time = strtotime($item->Booked);
    $mailView->Day = date('d', $time);
    $mailView->Month = Yii::app()->getLocale()->getMonthName(intval(date('m', $time)));
    $mailView->Time = date('H:i', $time);


    $mail = new PHPMailer(false);
    $mail->ParamOdq = true;
    $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
    $mail->IsHTML($isHTML);
    $email = !empty($user->Emails) ? $user->Emails[0]->Email : $user->Email;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return;
    }
    $mail->AddAddress($email);
    $mail->SetFrom('info@rif.ru', 'РИФ+КИБ 2012', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode('Срок бронирования проживания на РИФ+КИБ 2012 истекает в течение суток') .'?=';
    $mail->Body = $mailView;
    //$mail->Send();
    echo $mailView;
  }
}
