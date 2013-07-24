<?php
namespace mail\components;

abstract class Mail
{
  protected $mailer;
  public function __construct(Mailer $mailer)
  {
    $this->mailer = $mailer;
  }
  
  /**
   * @return string
   */
  abstract public function getFrom();
  
  /**
   * @return string
   */
  abstract public function getTo();

  /**
   * @return string
   */
  public function getFromName()
  {
    return 'RUNET-ID';
  }

  /**
   * @return string
   */
  public function getSubject()
  {
    return '';
  }

  /**
   * @return bool
   */
  public function isHtml()
  {
    return false;
  }

  /**
   * @return string
   */
  abstract public function getBody();

  /**
   * @return array
   */
  public function getAttachments()
  {
    return array();
  }
  
  public function send()
  {
    if ($this->getBody() !== null && $this->getTo() !== null)
    {
      $this->mailer->send($this, $this->getHashSolt(), $this->getRepeat());
    }
  }

  protected function getHashSolt()
  {
    return null;
  }
  
  protected function getRepeat()
  {
    return true;
  }

  protected final function renderBody($view, $params)
  {
    $controller = new \CController('default', null);
    return $controller->renderPartial($view, $params, true);
  }
}
