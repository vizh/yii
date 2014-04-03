<?php
namespace mail\components\mailers\template;

abstract class BaseMailer implements ITemplateMailer
{
  protected $template;

  /**
   * @param \mail\models\Template $template
   */
  function __construct(\mail\models\Template $template)
  {
    $this->template = $template;
  }

  protected abstract function internalSend($users);

  /**
   * @param \user\models\User[] $users
   */
  public final function send($users)
  {
    $error = null;
    try
    {
      $this->internalSend($users);
    }
    catch (\Exception $e)
    {
      $error = $e->getMessage();
    }

    foreach ($users as $user)
    {
      $log = new \mail\models\TemplateLog();
      $log->UserId = $user->Id;
      $log->TemplateId = $this->template->Id;
      $log->Error = $error;
      $log->save();
    }
  }

  /**
   * @return string
   */
  protected function getMailLayout()
  {
    $controller = new \mail\components\MailController($this, $this->template->Layout == \mail\models\Layout::TwoColumn);
    \Yii::app()->getClientScript()->reset();
    return $controller->renderText('', true);
  }

  /**
   * @param \user\models\User $user
   * @return array[]
   */
  public function getAttachments(\user\models\User $user)
  {
    $attachments = [];
    if ($this->template->SendPassbook)
    {
      $participants = $user->Participants[0];
      $pkPass = new \application\components\utility\PKPassGenerator($participants->Event, $user, $participants->Role);
      $attachments['ticket.pkpass'] = $pkPass->runAndSave();
    }
    return $attachments;
  }

  /**
   * @return bool
   */
  public function getIsHasAttachments()
  {
    return ($this->template->SendPassbook);
  }
}