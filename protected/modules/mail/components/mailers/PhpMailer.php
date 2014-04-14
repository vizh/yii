<?php
namespace mail\components\mailers;

class PhpMailer extends \mail\components\Mailer
{
  protected function internalSend($mails)
  {
    foreach($mails as $mail)
    {
      $mailer = new \ext\mailer\PHPMailer(true);
      $mailer->AddAddress($mail->getTo());
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
    }
  }
}
