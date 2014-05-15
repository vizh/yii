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

    public function init()
    {
        if ($this->getIsHasDefaultResources() && strstr(\Yii::app()->getRequest()->getHostInfo(), 'admin.') == false)
        {
            $this->registerDefaultResources();
        }
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

    public function __set($name, $value)
    {
        if (in_array($name, $this->getAttributeNames()))
        {
            $attribute = $this->getEvent()->getAttribute($name);
            if ($attribute == null)
            {
                $attribute = new \event\models\Attribute();
                $attribute->Name = $name;
                $attribute->EventId = $this->getEvent()->Id;
                $this->getEvent()->addAttribute($name, $attribute);
            }
            $attribute->Value = $value;
            $attribute->save();
        }
        else
        {
            parent::__set($name, $value);
        }
    }


    public function __isset($name)
    {
        if (in_array($name, $this->getAttributeNames()))
        {
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
        if ($this->adminPanel == null)
        {
            $this->adminPanel = $this->getInternalAdminPanel();
        }
        return $this->adminPanel;
    }

    protected function getInternalAdminPanel()
    {
        $class = get_class($this);
        $class = substr($class, mb_strrpos($class, 'widgets\\')+8,mb_strlen($class));
        $class = \Yii::getExistClass('\event\widgets\panels', $class, 'Base');
        return new $class($this);
    }

    /**
     * @return void
     */
    public function process()
    {

    }

    public function getIsHasDefaultResources()
    {
        return false;
    }

    protected function registerDefaultResources()
    {
        $class = get_class($this);
        $class = mb_strtolower(mb_substr($class, strrpos($class, '\\')+1, mb_strlen($class)));
        $assetsPath = \Yii::getPathOfAlias('event.widgets.assets').DIRECTORY_SEPARATOR;
        $path = $assetsPath.'js'.DIRECTORY_SEPARATOR.$class.'.js';

        if (file_exists($path))
            \Yii::app()->clientScript->registerScriptFile(\Yii::app()->assetManager->publish($path));

        $path = $assetsPath.'css'.DIRECTORY_SEPARATOR.$class.'.css';

        if (file_exists($path))
            \Yii::app()->clientScript->registerCssFile(\Yii::app()->assetManager->publish($path));
    }


    /**
     * @return bool
     */
    public function getIsActive()
    {
        return true;
    }
}