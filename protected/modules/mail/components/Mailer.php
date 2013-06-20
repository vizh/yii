<?php
namespace mail\components;

class Mailer
{
  public function send(Mail $mail, $to, $hashSolt = null, $repeat = false)
  {
    $mailer = new \ext\mailer\PHPMailer(true);
    
    $hash = md5(get_class($mail).$to.$mail->getSubject());
    if ($hashSolt !== null)
    {
      $hash .= $hashSolt;
    }
    
    if (!$repeat)
    {
      $log = \mail\models\Log::model()->byHash($hash)->find();
      if ($log !== null)
        return;
    }
    
    $mailer->AddAddress($to);
    $mailer->SetFrom($mail->getFrom(), $mail->getFromName());
    $mailer->CharSet = 'utf-8';
    $mailer->Subject = '=?UTF-8?B?'. base64_encode($mail->getSubject()) .'?=';
    $mailer->Mailer = 'mail';
    
    $mailer->IsHTML($mail->isHtml());
    if ($mail->isHtml())
    {
      $mailer->MsgHTML($mail->getBody());
    }
    else
    {
      $mailer->Body = $mail->getBody();
    }

    foreach ($mail->getAttachments() as $name => $attachment)
    {
      $mailer->AddAttachment($attachment, $name);
    }
    
    
    $log = new \mail\models\Log();
    $log->From = $mail->getFrom();
    $log->To = $to;
    $log->Subject = $mail->getSubject();
    $log->Hash = $hash;
    
    try 
    {
      $mailer->Send();
    }
    catch (\Exception $e)
    {
      $log->Error = $e->getMessage();
    }
    $log->save();
  }
}
