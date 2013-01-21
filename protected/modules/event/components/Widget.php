<?php
namespace event\components;

abstract class Widget extends \CWidget implements IWidget
{
  /**
   * @var \event\models\Event
   */
  public $event;

  /**
   * @return string
   */
  abstract public function getTitle();

  /**
   * @return string
   */
  public function getName()
  {
    return ltrim(get_class($this), '\\');
  }

  public function getNameId()
  {
    return str_replace('\\', '_', $this->getName());
  }

  /**
   * @return string
   */
  abstract public function getPosition();

  /**
   * @return void
   */
  public function process()
  {

  }   
}