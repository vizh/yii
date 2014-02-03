<?php
namespace mail\components\mail;

class Template extends \mail\components\Mail
{
  protected $template;
  protected $user;

  public function __construct(\mail\components\Mailer $mailer, \mail\models\Template $template, \user\models\User $user)
  {
    parent::__construct($mailer);
    $this->template = $template;
    $this->user = $user;
  }

  public function isHtml()
  {
    return true;
  }

  public function getFromName()
  {
    return $this->template->FromName;
  }

  public function getSubject()
  {
    return $this->template->Subject;
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
  public function getTo()
  {
    return $this->user->Email;
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return $this->renderBody($this->template->getViewName(), ['user' => $this->user]);
  }

  protected function getRepeat()
  {
    return true;
  }

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
   * @return bool
   */
  public function getIsHasLog()
  {
    if ($this->template->getIsTestMode())
      return false;

    return \mail\models\TemplateLog::model()->byTemplateId($this->template->Id)->byUserId($this->user->Id)->exists();
  }

  /**
   * @return \CModel
   */
  public function getLog()
  {
    $log = new \mail\models\TemplateLog();
    $log->UserId = $this->user->Id;
    $log->TemplateId = $this->template->Id;
    return $log;
  }

  protected function renderBody($view, $params)
  {
    if ($this->template->Layout == \mail\models\Layout::None)
    {
      return parent::renderBody($view, $params);
    }
    $controller = new \mail\components\MailController($this->user, ($this->template->Layout == \mail\models\Layout::TwoColumn));
    \Yii::app()->getClientScript()->reset();
    return $controller->render($view, $params, true);
  }


}