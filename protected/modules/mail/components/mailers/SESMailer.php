<?php
namespace mail\components\mailers;

use application\components\Exception;
use Aws\Ses\SesClient;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Exception\CommandTransferException;
use mail\components\Mailer;
use Yii;

/**
 * Class SESMailer performs sending by using Amazon SES
 */
class SESMailer extends Mailer
{
    /**
     * Returns param from params array. Checks for requirements of parameters
     *
     * @param array $params
     * @param string $param
     * @param bool $required
     * @return mixed
     * @throws \Exception
     */
    private static function getParam($params, $param, $required = false)
    {
        if ($required === true && empty($params[$param])) {
            throw new \Exception("'$param' parameter is required");
        }

        return isset($params[$param]) ? $params[$param] : null;
    }

    /**
     * Clean filename function - to be mail friendly
     *
     * @param string $str
     * @param int $limit
     * @param array $replace
     * @param string $delimiter
     * @return string
     */
    private static function cleanFilename($str, $limit = 0, $replace = [], $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\.\/_| -]/", '', $clean);
        $clean = preg_replace("/[\/| -]+/", '-', $clean);

        if ($limit > 0) {
            //don't truncate file extension
            $arr = explode(".", $clean);
            $size = count($arr);
            $base = "";
            $ext = "";
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    if ($i < $size - 1) { //if it's not the last item, add to $bn
                        $base .= $arr[$i];
                        //if next one isn't last, add a dot
                        if ($i < $size - 2)
                            $base .= ".";
                    } else {
                        if ($i > 0)
                            $ext = ".";
                        $ext .= $arr[$i];
                    }
                }
            }
            $bn_size = mb_strlen($base);
            $ex_size = mb_strlen($ext);
            $bn_new = mb_substr($base, 0, $limit - $ex_size);
            // doing again in case extension is long
            $clean = mb_substr($bn_new.$ext, 0, $limit);
        }

        return $clean;
    }

    /**
     * @param \mail\components\Mail[] $mails
     */
    public function internalSendNew($mails)
    {
        $client = $this->getSesClient();

        $commands = [];
        foreach ($mails as $mail) {
            try
            {
                $attachments = [];
                foreach ($mail->getAttachments() as $name => $attachment) {
                    if (!file_exists($attachment[1]))
                        throw new Exception("Ошибка отправки сообщения: Вложенный файл '{$attachment[1]}' не найден");

                    $attachments[self::cleanFilename($name, 60)]
                        = $attachment[1];
                }

                $commands[] = $client->getCommand('SendRawEmail', [
                    'RawMessage' => [
                        'Data' => base64_encode(
                            Mailer::createRawMail(
                                $mail->getTo(),
                                [$mail->getFrom() => $mail->getFromName()],
                                $mail->getSubject(),
                                $mail->getBody(),
                                $attachments
                            )
                        )
                    ]
                ]);
            }

            catch (\Exception $e) {
                Yii::log("Error construct email for {$mail->getTo()} because of {$e->getMessage()}: {$e->getTraceAsString()}", \CLogger::LEVEL_ERROR);
            }
        }

        try {
            Yii::log(sprintf('Mailer started sending %d mails...', count($commands)));
            $client->execute($commands);
            Yii::log('Mailer done sending');
        } catch (CommandTransferException $e) {
            $message = "Failed mails:\n";
            foreach ($e->getFailedCommands() as $command) {
                $message .= sprintf("\t%s\n", $e->getExceptionForFailedCommand($command)->getMessage());
            }
            Yii::log($message);
        }

        /** @var CommandInterface $command */
        foreach ($commands as $command) {
            Yii::log(print_r($command->getResponse()->getMessage(), true));
        }
    }

    /**
     * @param \mail\components\Mail[] $mails
     */
    public function internalSend($mails)
    {
        // Пурген для рассылок
        if (defined('NEW_SES_SENDER')) {
            $this->internalSendNew($mails);
            return;
        }

        $client = $this->getSesClient();

        foreach ($mails as $mail) {
            try
            {
                $args = [
                    'to' => $mail->getTo(),
                    'subject' => $mail->getSubject(),
                    'message' => $mail->getBody(),
                    'from' => $mail->getFrom(),
                    'fromName' => $mail->getFromName()
                ];

                $attachments = $mail->getAttachments();

                if (count($attachments)) {
                    $args['files'] = [];
                    foreach ($attachments as $name => $attachment) {
                        $args['files'][] = [
                            'name' => $name,
                            'filepath' => $attachment[1],
                            'mime' => $attachment[0]
                        ];
                    }
                }

                $result = $this->sendMailInternal($client, $args);

                if ($result['success']) {
                    Yii::log("Email by Amazon SES to {$mail->getTo()} is sent! Message ID: {$result['message_id']}", \CLogger::LEVEL_INFO);
                } else {
                    Yii::log("Email by Amazon SES to {$mail->getTo()} was not sent. Error message: {$result['result_text']}", \CLogger::LEVEL_ERROR);
                }
            }

            catch (\Exception $e) {
                Yii::log("Error construct email for {$mail->getTo()} because of {$e->getMessage()}: {$e->getTraceAsString()}", \CLogger::LEVEL_ERROR);
            }
        }
    }

    /**
     * Usage:
     *
     * ```
     * $params = array(
     *      "to" => "email1@gmail.com" OR ["email1@gmail.com" => "To Name"] OR [
     *              "email1@gmail.com" => "To Name 1",
     *              "email2@gmail.com" => "To Name 2",
     *              ...
     *      ],
     *      "subject" => "Some subject",
     *      "message" => "<strong>Some email body</strong>",
     *      "from" => "sender@verifiedbyaws" OR ["sender@verifiedbyaws" => "Sender Name"],
     *      //OPTIONAL
     *      "replyTo" => "reply_to@gmail.com" OR ["reply_to@gmail.com" => "ReplyTo Name"],
     *      //OPTIONAL
     *      "files" => array(
     *          1 => array(
     *              "name" => "filename1",
     *              "filepath" => "/path/to/file1.txt",
     *              "mime" => "application/octet-stream"
     *          ),
     *          2 => array(
     *              "name" => "filename2",
     *              "filepath" => "/path/to/file2.txt",
     *              "mime" => "application/octet-stream"
     *          ),
     *      )
     * );
     *
     * $res = SESMailer::sendMail($params);
     * ```
     *
     * NOTE: When sending a single file, omit the key (ie. the '1 =>')
     * or use 0 => array(...) - otherwise the file will come out garbled
     * ie. use:
     *    "files" => array(
     *        0 => array( "name" => "filename", "filepath" => "path/to/file.txt",
     *        "mime" => "application/octet-stream")
     *
     * For the 'to' parameter, you can send multiple recipiants with an array
     *    "to" => array("email1@gmail.com", "other@msn.com")
     * use $res['success'] to check if it was successful
     * use $res['message_id'] to check later with Amazon for further processing
     * use $res['result_text'] to look for error text if the task was not successful
     *
     * @param SesClient $client
     * @param array $params - array of parameters for the email
     * @return array
     * @throws \Exception
     */
    private function sendMailInternal(SesClient $client, $params)
    {
        $to = self::getParam($params, 'to', true);
        $subject = self::getParam($params, 'subject', true);
        $body = self::getParam($params, 'message', true);
        $from = self::getParam($params, 'from', true);
        $fromName = self::getParam($params, 'fromName', true);
        $replyTo = self::getParam($params, 'replyTo');
        $files = self::getParam($params, 'files');

        $res = [
            'success' => true,
            'result_text' => null,
            'message_id' => null
        ];

        $attachments = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                if (file_exists($file['filepath']) === false) {
                    throw new Exception("Ошибка отправки сообщения: Вложенный файл '{$file['filepath']}' не найден");
                }
                $clean_filename = self::cleanFilename($file["name"], 60);
                $attachments[$clean_filename] = $file['filepath'];
            }
        }

        $msg = Mailer::createRawMail(
            $to,
            [$from => $fromName],
            $subject,
            $body,
            $attachments,
            $replyTo
        );

        // Для AWS обязательно передавать список получателей в виде массива
        if (!is_array($to))
            $to = [$to];

        try {
            $ses_result = $client->sendRawEmail([
                'RawMessage' => [
                    'Data' => base64_encode($msg)
                ]
            ]);

            if ($ses_result) {
                $res['message_id'] = $ses_result->get('MessageId');
            } else {
                throw new \Exception('Amazon SES did not return a MessageId');
            }
        } catch (\Exception $e) {
            $res['success'] = false;
            $res['result_text'] = sprintf("%s: From: '%s', To: '%s', Subject: '%s'",
                $e->getMessage(),
                $from,
                implode(', ', $to),
                $subject
            );
        }

        return $res;
    }

    private function getSesClient()
    {
        $prms = Yii::app()->getParams();

        return SesClient::factory([
            'key' => $prms['AwsKey'],
            'secret' => $prms['AwsSecret'],
            'region' => $prms['AwsSesRegion'],
            'version'=> 'latest'
        ]);
    }
}
