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
    return '';
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
}
