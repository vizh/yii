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
  public function getToName()
  {
    return '';
  }

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
    if ($this->getBody() !== null && $this->getTo() !== null && ($this->getRepeat() || !$this->getIsHasLog()))
    {
      $this->mailer->send($this);
    }
  }

  /**
   * @return bool
   */
  public function getIsHasLog()
  {
    return \mail\models\Log::model()->byHash($this->getHash())->exists();
  }

  /**
   * @return ILog
   */
  public function getLog()
  {
    $log = new \mail\models\Log();
    $log->From = $this->getFrom();
    $log->To   = $this->getTo();
    $log->Subject = $this->getSubject();
    $log->Hash = $this->getHash();
    return $log;
  }

  /**
   * @return string
   */
  public function getHash()
  {
    $hash = md5(get_class($this).$this->getTo().$this->getSubject());
    if ($this->getHashSolt() !== null)
    {
      $hash .= $this->getHashSolt();
    }
    return $hash;
  }

  /**
   * @return null|string
   */
  protected function getHashSolt()
  {
    return null;
  }

  /**
   * @return bool
   */
  protected function getRepeat()
  {
    return true;
  }

  protected function renderBody($view, $params)
  {
    $controller = new \CController('default', null);
    return $controller->renderPartial($view, $params, true);
  }
}
