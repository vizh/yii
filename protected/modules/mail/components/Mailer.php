<?php
namespace mail\components;

use CText;
use Exception;
use Yii;

abstract class Mailer
{
    /**
     * @param Mail[] $mails
     * @return void
     */
    protected abstract function internalSend($mails);

    /**
     * Отправка писем
     *
     * @param Mail[] $mails
     */
    public final function send($mails)
    {
        if (is_array($mails) === false) {
            $mails = [$mails];
        }

        // Убеждаемся, что письма не будут отправляться на поддельные адреса
        $mails = array_filter($mails, function (Mail $mail) {
            return CText::isRealEmail($mail->getTo());
        });

        if (empty($mails) === false) {
            $error = null;

            try {
                $this->internalSend($mails);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }

            foreach ($mails as $mail) {
                $log = $mail->getLog();
                if ($error !== null) {
                    $log->setError($error);
                }
                $log->save();
            }
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
        $params = Yii::app()->getParams();
        if (!empty($params['MailMirrorAddress'])) {
            $message->addTo($params['MailMirrorAddress'], 'RUNET-ID Developer');
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
