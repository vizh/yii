<?php
namespace mail\components\mailers;

class MandrillMailer extends \mail\components\Mailer
{
    const ApiKey = 'trMZUlPTlLyIoUJRAQoFrw';
    const TemplateName = 'RUNETID';
    const GoogleAnalyticsCampaign = 'mail@runet-id.com';

    /**
     * @param \mail\components\Mail[] $mails
     */
    public function internalSend($mails)
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

    /**
     * @return string
     */
    public function getVarNameMailBody()
    {
        return 'MailBody';
    }

    /**
     * @return string
     */
    public function getTagMailBody()
    {
        return '*|MailBody|*';
    }
}