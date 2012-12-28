<?php
namespace event\components;

abstract class Widget extends \CWidget
{
  public $event;
  public $position;

  abstract public function widgetName();

  public function process()
  {

  }   
}