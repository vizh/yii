<?php
namespace event\components;
use application\components\Exception;

abstract class Widget extends \CWidget implements IWidget
{
  /**
   * @return string[]
   */
  public function getAttributeNames()
  {
    return array();
  }

  public function __get($name)
  {
    if (in_array($name, $this->getAttributeNames()))
    {
      $attribute = $this->event->getAttribute($name);
      if ($attribute === null)
      {
        throw new Exception('Необходимо указать параметр ' . $name);
      }
      elseif (is_array($attribute))
      {
        $result = array();
        foreach ($attribute as $attr)
        {
          $result[] = $attr->Value;
        }
        return $result;
      }
      else
      {
        return $attribute->Value;
      }
    }
    else
    {
      return parent::__get($name);
    }
  }

  /**
   * @var \event\models\Event
   */
  public $event;

  /** @var bool */
  public $eventPage = true;

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

  public function getAdminPanel()
  {
    return NULL;
  }


  /**
   * @return void
   */
  public function process()
  {

  }   
}