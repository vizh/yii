<?php
namespace mail\components\mail;

class Template extends \mail\components\MailLayout
{
  protected $user;
  protected $template;

  public function __construct(\mail\components\Mailer $mailer, \user\models\User $user, \mail\models\Template $template)
  {
    parent::__construct($mailer);
    $this->user = $user;
    $this->template = $template;
  }

  /**
   * @return bool
   */
  public function isHtml()
  {
    return true;
  }

  /**
   * @return string
   */
  public function getFrom()
  {
    return $this->template->From;
  }

  /**
   * @return string
   */
  public function getFromName()
  {
    return $this->template->FromName;
  }

  /**
   * @return string
   */
  public function getTo()
  {
    return $this->user->Email;
  }

  /**
   * @return string
   */
  public function getToName()
  {
    return $this->user->getFullName();
  }

  /**
   * @return array
   */
  public function getAttachments()
  {
    if ($this->template->SendPassbook)
    {
      $participants = $this->user->Participants[0];
      $pkPass = new \application\components\utility\PKPassGenerator($participants->Event, $this->user, $participants->Role);
      return [
        'ticket.pkpass' => $pkPass->runAndSave()
      ];
    }
    return [];
  }

  /**
   * @return string
   */
  public function getSubject()
  {
    return $this->template->Subject;
  }

  /**
   * @return bool
   */
  protected function getRepeat()
  {
    return true;
  }

  public function getLog()
  {
    $log = new \mail\models\TemplateLog();
    $log->UserId = $this->user->Id;
    $log->TemplateId = $this->template->Id;
    return $log;
  }

  /**
   * @return string
   */
  public function getLayoutName()
  {
    return $this->template->Layout;
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return $this->renderBody($this->template->getViewName(), ['user' => $this->user]);
  }

  function getUser()
  {
    return $this->user;
  }

  public function showUnsubscribeLink()
  {
    return $this->template->ShowUnsubscribeLink;
  }

  public function showFooter()
  {
    return $this->template->ShowFooter;
  }


}