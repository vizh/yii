<?php
namespace mail\components\mailers;

require_once \Yii::getPathOfAlias('ext') . DIRECTORY_SEPARATOR . 'aws.phar';

use mail\components\Mail;

class AmazonMailer extends \mail\components\Mailer
{

  protected function internalSend(Mail $mail)
  {
    $client = \Aws\Ses\SesClient::factory([
      'key' => 'AKIAJAF2OQWUAZB4M64Q',
      'secret' => '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',
      'region' => 'us-east-1'
    ]);

    $response = $client->sendEmail([
      'Source' => $mail->getFrom(),
      'Destination' => [
        'ToAddresses' => $mail->getTo()
      ],
      'Message' => [
        'Subject' => ['Data' => $mail->getSubject()],
        'Body' => ['Html' => ['Data' => $mail->getBody()]]
      ],
    ]);

    var_dump($response);
    echo '234';
  }
}