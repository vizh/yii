<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 26.08.2015
 * Time: 16:12
 */

namespace application\components\web;

class Widget extends \CWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->getIsHasDefaultResources()) {
            $this->registerDefaultResources();
        }
    }

    /**
     * Возвращает true если у виджета есть ресурсы, которые требуется подключить при регистрации виджета
     * @return bool
     */
    public function getIsHasDefaultResources()
    {
        return false;
    }

    /**
     * Регистрация ресурсов виджета
     */
    protected function registerDefaultResources()
    {
        $class = strtolower(get_class($this));
        $assetsAlias = strtr($class, ['\\' => '.', 'widgets' => 'widgets.assets']);

        $path = \Yii::getPathOfAlias(strtr($assetsAlias, ['.assets' => '.assets.js'])).'.js';
        if (file_exists($path)) {
            \Yii::app()->getClientScript()->registerScriptFile(\Yii::app()->getAssetManager()->publish($path));
        }

        $path = \Yii::getPathOfAlias(strtr($assetsAlias, ['.assets' => '.assets.css'])).'.css';
        if (file_exists($path)) {
            \Yii::app()->getClientScript()->registerCssFile(\Yii::app()->getAssetManager()->publish($path));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return ltrim(get_class($this), '\\');
    }

    /**
     * @return string
     */
    public function getNameId()
    {
        return str_replace('\\', '_', $this->getName());
    }
}