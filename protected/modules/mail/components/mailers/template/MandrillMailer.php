<?php
namespace mail\components\mailers\template;


class MandrillMailer extends BaseMailer
{
  const ApiKey = 'trMZUlPTlLyIoUJRAQoFrw';
  const TemplateName = 'RUNETID';
  const GoogleAnalyticsCampaign = 'mail@runet-id.com';

  /**
   * @param \user\models\User[] $users
   */
  public function internalSend($users)
  {
    $to = [];
    $vars = [];
    $attachments = [];
    foreach ($users as $user)
    {
      $to[] = [
        'email' => $user->Email,
        'name'  => $user->getFullName(),
        'type'  => 'to'
      ];

      $var = [
        'rcpt' => $user->Email,
        'vars' => []
      ];
      foreach ($this->template->getBodyVarValues($user) as $name => $content)
      {
        $var['vars'][] = [
          'name' => $name,
          'content' => $content
        ];
      }

      foreach ($this->getAttachments($user) as $name => $path)
      {
        $attachments[] = [
          'name' => $name,
          'type' => \CFileHelper::getMimeType($path),
          'content' => base64_encode(file_get_contents($path))
        ];
      }
      $vars[] = $var;
    }

    $message = $this->getBaseMessage();
    $message['to'] = $to;
    $message['merge_vars'] = $vars;
    $message['attachments'] = $attachments;
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

  /**
   * @return sring
   */
  public function getVarNameUserUrl()
  {
    return 'UserUrl';
  }

  /**
   * @return sring
   */
  public function getTagUserUrl()
  {
    return '*|UserUrl|*';
  }

  /**
   * @return sring
   */
  public function getVarNameUserRunetId()
  {
    return 'UserRunetId';
  }

  /**
   * @return sring
   */
  public function getTagUserRunetId()
  {
    return '*|UserRunetId|*';
  }

  /**
   * @return sring
   */
  public function getVarNameUnsubscribeUrl()
  {
    return 'UnsubscribeUrl';
  }

  /**
   * @return sring
   */
  public function getTagUnsubscribeUrl()
  {
    return '*|UnsubscribeUrl|*';
  }

  private function getBaseMessage()
  {
    $message = array(
      'html' => $this->getMailLayout(),
      'text' => null,
      'subject' => $this->template->Subject,
      'from_email' => $this->template->From,
      'from_name' => $this->template->FromName,
      'to' => [],
      'headers' => ['Reply-To' => $this->template->From],
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