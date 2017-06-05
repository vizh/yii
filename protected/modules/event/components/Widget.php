<?php
namespace event\components;

use application\components\Exception;
use application\components\web\Widget as CWidget;

abstract class Widget extends CWidget implements IWidget
{
    /**
     * @return string[]
     */
    public function getAttributeNames()
    {
        return [];
    }

    public function init()
    {
        $isAdmin = strstr(\Yii::app()->getRequest()->getHostInfo(), 'admin.');
        if ($this->getIsHasDefaultResources() && !$isAdmin && $this->getIsActive()) {
            $this->registerDefaultResources();
        }
    }

    public function __get($name)
    {
        if (in_array($name, $this->getAttributeNames())) {
            $attribute = $this->event->getAttribute($name);
            if ($attribute === null) {
                throw new Exception('Необходимо указать параметр '.$name);
            } elseif (is_array($attribute)) {
                $result = [];
                foreach ($attribute as $attr) {
                    $result[] = $attr->Value;
                }
                return $result;
            } else {
                return $attribute->Value;
            }
        } else {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->getAttributeNames())) {
            $attribute = $this->getEvent()->getAttribute($name);
            if ($attribute == null) {
                $attribute = new \event\models\Attribute();
                $attribute->Name = $name;
                $attribute->EventId = $this->getEvent()->Id;
                $this->getEvent()->addAttribute($name, $attribute);
            }
            $attribute->Value = $value;
            $attribute->save();
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        if (in_array($name, $this->getAttributeNames())) {
            $attribute = $this->getEvent()->getAttribute($name);
            return $attribute !== null;
        }
        return parent::__isset($name);
    }

    /**
     * @var \event\models\Event
     */
    public $event;

    /**
     *
     * @return \event\models\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

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

    private $adminPanel = null;

    public function getAdminPanel()
    {
        if ($this->adminPanel == null) {
            $this->adminPanel = $this->getInternalAdminPanel();
        }
        return $this->adminPanel;
    }

    protected function getInternalAdminPanel()
    {
        $class = get_class($this);
        $class = substr($class, mb_strrpos($class, 'widgets\\') + 8, mb_strlen($class));
        $class = \Yii::getExistClass('\event\widgets\panels', $class, 'Base');
        return new $class($this);
    }

    /**
     * @return void
     */
    public function process()
    {
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return true;
    }

    /**
     * Название виджета
     * @return string
     */
    abstract public function getTitle();

    /**
     * Название виджета для административного интерфейса
     * @return string
     */
    public function getTitleAdmin()
    {
        return $this->getTitle();
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return \Yii::app()->getUser()->getCurrentUser();
    }
}