<?php
namespace event\components;

interface IWidgetAdminPanel
{
  public function __construct($widget);
  public function getEvent();

  public function addError($message);
  
  /**
   * 
   * @param string $header
   * @param string $footer
   * @return string
   */
  public function errorSummary($header = '', $footer = '');
  
  /**
   * @return bool
   */
  public function process();
  
  public function __toString();
}
