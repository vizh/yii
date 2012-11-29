<?php
namespace application\components;

/**
 * Advanced ActiveRecord to handle model events globally
 * 
 * Please, visit http://weavora.com/blog/2011/01/24/yii-events-observer/ to get
 * installation and usage notes
 *
 * @author Weavora Team
 * @copyright Weavora 
 * @link http://weavora.com
 * @version 0.0.1
 */
class ActiveRecord extends \CActiveRecord
{
	private static $_events = array();

  public function __set($name, $value)
  {
    if(strncasecmp($name,'on',2)===0 && method_exists($this, $name))
    {
      self::$_events[] = array(
        'component' => get_class($this),
        'name' => $name,
        'handler' => $value
      );
    }

    parent::__set($name, $value);
  }


  /**
	 * Attach exists events while model creation
	 */
	public function init()
	{
		$this->attachEvents($this->events());
	}
	
	/**
	 * Attach events
	 *
	 * @param array $events
	 */
	public function attachEvents($events) 
	{
		foreach ($events as $event) {
			if ($event['component'] == get_class($this))
				parent::attachEventHandler($event['name'], $event['handler']);
		}
	}
	
	/**
	 * Get exists events
	 *
	 * @return array
	 */
	public function events() 
	{
		return self::$_events;
	}
	
	/**
	 * Attach event handler
	 *
	 * @param string $name Event name
	 * @param mixed $handler Event handler
	 */
	public function attachEventHandler($name,$handler)
	{
		self::$_events[] = array(
			'component' => get_class($this),
			'name' => $name,
			'handler' => $handler
		);
		parent::attachEventHandler($name, $handler);
	}
	
	/**
	 * Dettach event hander
	 *
	 * @param string $name Event name
	 * @param mixed $handler Event handler
	 * @return bool
	 */
	public function detachEventHandler($name,$handler)
	{
		foreach (self::$_events as $index => $event) {
			if ($event['name'] == $name && $event['handler'] == $handler)
				unset(self::$_events[$index]);
		}
		return parent::detachEventHandler($name, $handler);
	}
}