<?php

namespace mail\components\mailers;

class PhpMailer extends \mail\components\Mailer
{
    /**
     * @param \mail\components\Mail[] $mails
     */
    protected function internalSend($mails)
    {
        foreach ($mails as $mail) {
            $mailer = new \PHPMailer(true);
            $mailer->addAddress($mail->getTo());
            $mailer->setFrom($mail->getFrom(), $mail->getFromName());
            $mailer->CharSet = 'utf-8';
            $mailer->Subject = '=?UTF-8?B?'.base64_encode($mail->getSubject()).'?=';
            $mailer->Mailer = 'mail';

            if ($mail->isHtml()) {
                $mailer->msgHTML($mail->getBody());
            } else {
                $mailer->Body = $mail->getBody();
            }

            foreach ($mail->getAttachments() as $name => $attachment) {
                $mailer->addAttachment($attachment, $name);
            }

            $mailer->send();
        }
    }
}
