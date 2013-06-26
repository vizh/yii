<?php
namespace mail\components;

abstract class Mail
{
  /**
   * @return string
   */
  abstract public function getFrom();

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
  
  protected final function renderBody($view, $params)
  {
    $controller = new \CController('default', null);
    return $controller->renderPartial($view, $params, true);
  }
}
