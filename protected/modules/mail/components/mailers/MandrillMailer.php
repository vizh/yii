<?php
namespace mail\components\mailers;


class MandrillMailer extends \mail\components\Mailer
{
  const ApiKey = 'trMZUlPTlLyIoUJRAQoFrw';
  const TemplateName = 'RUNETID';
  const GoogleAnalyticsCampaign = 'mail@runet-id.com';

  /**
   * @param \mail\components\Mail[] $users
   */
  public function internalSend($mails)
  {
    $to = [];
    $vars = [];
    $attachments = [];

    /** @var \mail\components\Mail $mail */
    foreach ($mails as $mail)
    {
      $to[] = [
        'email' => $mail->getTo(),
        'name'  => $mail->getToName(),
        'type'  => 'to'
      ];

      $vars[] = [
        'rcpt' => $mail->getTo(),
        'vars' => [
          0 => [
            'name' => $this->getVarNameMailBody(),
            'content' => $mail->getBody()
          ]
        ]
      ];
    }

    foreach ($mails[0]->getAttachments() as $name => $path)
    {
      $attachments[] = [
        'name' => $name,
        'type' => \CFileHelper::getMimeType($path),
        'content' => base64_encode(file_get_contents($path))
      ];
    }

    $message = $this->getBaseMessage();
    $message['to'] = $to;
    $message['subject'] = $mails[0]->getSubject();
    $message['from_email'] = $mails[0]->getFrom();
    $message['from_name'] = $mails[0]->getFromName();
    $message['headers']['Reply-To'] = $mails[0]->getFrom();
    $message['merge_vars'] = $vars;
    $message['attachments'] = $attachments;
    if ($mails[0]->getIsPriority()) {
        $message['important'] = true;
    }
    \Yii::import('ext.Mandrill.Mandrill');
    $mandrill = new \Mandrill(self::ApiKey);
    $mandrill->messages->sendTemplate(self::TemplateName, [], $message);
  }

  /**
   * @return sring
   */
  public function getVarNameMailBody()
  {
    return 'MailBody';
  }

  /**
   * @return sring
   */
  public function getTagMailBody()
  {
    return '*|MailBody|*';
  }

  private function getBaseMessage()
  {
    $message = array(
      'html' => $this->getTagMailBody(),
      'text' => null,
      'subject' => '',
      'from_email' => '',
      'from_name' => '',
      'to' => [],
      'headers' => [],
      'important' => false,
      'track_opens' => null,
      'track_clicks' => null,
      'auto_text' => true,
      'auto_html' => null,
      'inline_css' => null,
      'url_strip_qs' => null,
      'preserve_recipients' => false,
      'view_content_link' => null,
      'bcc_address' => null,
      'tracking_domain' => null,
      'signing_domain' => null,
      'return_path_domain' => null,
      'merge' => true,
      'global_merge_vars' => [],
      'merge_vars' => [],
      'tags' => [],
      'subaccount' => null,
      'google_analytics_domains' => [RUNETID_HOST],
      'google_analytics_campaign' => self::GoogleAnalyticsCampaign,
      'metadata' => ['website' => RUNETID_HOST],
      'recipient_metadata' => [],
      'attachments' => [],
      'images' => []
    );
    return $message;
  }
}