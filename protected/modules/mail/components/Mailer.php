<?php
namespace mail\components;

class Mailer
{
  public function send(Mail $mail, $to, $useLog = true)
  {
    $mailer = new \ext\mailer\PHPMailer(false);

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
    

    $mailer->Send();
    
    if ($useLog)
    {
      $logMsg = "time   : ".date('d.m.Y H:i:s')."\r\nfrom   : ".$mail->getFrom()."\r\nto     : ".$to."\r\nsubject: ".$mail->getSubject()."\r\n---\r\n";
      $logPath = \Yii::getPathOfAlias('mail.data');
      $logFile = fopen($logPath.DIRECTORY_SEPARATOR.'system.log',"a+");
      fwrite($logFile, $logMsg);
    }
  }
}
