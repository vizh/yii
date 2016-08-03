<?php
namespace mail\components;

use Yii;

abstract class Mailer
{
    /**
     * @param Mail[] $mails
     * @return void
     */
    protected abstract function internalSend($mails);

    public final function send($mails)
    {
        if (!is_array($mails)) {
            $mails = [$mails];
        }

        $error = null;
        try {
            $this->internalSend($mails);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        /** @var Mail $mail */
        foreach ($mails as $mail) {
            $log = $mail->getLog();
            if ($error !== null) {
                $log->setError($error);
            }
            $log->save();
        }
    }

    /**
     * Функция позволяет создать письмо в конечном виде, которое можно передавать в Amazon SES или Gmail
     * @param array|string $to - если массив, то это список получаетето ключ - имя получателя, значение - email получателя
     * @param array|string $from - если массив, то ключ - имя отправителя, значение - email отправителя
     * @param string $subject
     * @param string $body
     * @param null|array $attachments
     * @param string|array $replyTo
     * @return string
     */
    public static function createRawMail($to, $from, $subject, $body, $attachments = null, $replyTo = null)
    {
        spl_autoload_unregister(array('YiiBase','autoload'));
        Yii::import('ext.swiftmailer.lib.swift_required', true);
        spl_autoload_register(array('YiiBase','autoload'));
        $message = \Swift_Message::newInstance();

        $message->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setContentType('text/html; charset=UTF-8')
            ->setBody($body, 'text/html');

        if (!empty($replyTo)) {
            $message->setReplyTo($replyTo);
        }

        // Дублирование сообщения на адрес разработчика в целях отладки
        if (!empty(Yii::app()->getParams()['MailMirrorAddress'])) {
            $message->addTo(Yii::app()->getParams()['MailMirrorAddress'], 'RUNET-ID Developer');
        }

        //вложения
        if (!empty($attachments)) {
            foreach ($attachments as $name => $attachment) {
                $message->attach(\Swift_Attachment::newInstance(
                    new \Swift_ByteStream_FileByteStream($attachment),
                    $name
                ));
            }
        }

        return $message->toString();
    }
}
