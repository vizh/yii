<?php
namespace application\components\controllers;

use application\components\WebModule;

/**
 * Class BaseController
 * @package application\components\controllers
 *
 * @method WebModule getModule()
 */
abstract class BaseController extends \CController
{
    public function filters()
    {
        return [
            'validateCsrf',
            'registerApis',
            'setHeaders',
            'initResources',
            [
                '\application\components\controllers\filters\UserReferralFilter'
            ]
        ];
    }

    /**
     * @param \CFilterChain $filterChain
     */
    public function filterSetHeaders($filterChain)
    {
        $this->setHeaders();
        $filterChain->run();
    }

    protected function setHeaders()
    {
        header('Content-type: text/html; charset=utf-8');
    }

    /**
     * @param \CFilterChain $filterChain
     */
    public function filterInitResources($filterChain)
    {
        $this->initResources();
        $filterChain->run();
    }

    /**
     * @param \CFilterChain $filterChain
     */
    public function filterValidateCsrf($filterChain)
    {
        if (isset($this->getModule()->csrfValidation) && $this->getModule()->csrfValidation) {
            \Yii::app()->request->enableCsrfValidation = true;
            \Yii::app()->request->validateCsrfToken(new \CEvent($this));
        }
        $filterChain->run();
    }

    /**
     * Регистрируем различные API
     * @param $filterChain
     */
    public function filterRegisterApis($filterChain)
    {
        $googleApis = $this->registeredGoogleApis();
        if (!empty($googleApis)) {
            $cs = \Yii::app()->getClientScript();
            $cs->registerScriptFile('https:'.\CGoogleApi::$bootstrapUrl, \CClientScript::POS_HEAD);
            $i = 0;
            foreach ($googleApis as $apiName => $config) {
                if (is_array($config)) {
                    $cs->registerScript(
                        'init-api'.$i++,
                        \CGoogleApi::load(
                            $apiName,
                            isset($config['version']) ? $config['version'] : '1',
                            isset($config['options']) ? $config['options'] : []
                        ),
                        \CClientScript::POS_HEAD
                    );
                } else {
                    $cs->registerScript('init-api'.$i++, \CGoogleApi::load($config), \CClientScript::POS_HEAD);
                }
            }
        }
        $filterChain->run();
    }

    /**
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed
     */
    protected function getParam($name, $defaultValue = null)
    {
        return \Yii::app()->request->getParam($name, $defaultValue);
    }

    protected function initResources()
    {
        $this->registerDefaultResources('js');
        $this->registerDefaultResources('css');
    }

    protected function registerDefaultResources($resourcesType)
    {
        $resourcesMap = [];
        $assetsPath = \Yii::getPathOfAlias($this->module->name.'.assets.'.$resourcesType).DIRECTORY_SEPARATOR;
        $resourcesMap[] = $assetsPath.'module.'.$resourcesType;
        $resourcesMap[] = $assetsPath.$this->getId().'.'.$resourcesType;
        $resourcesMap[] = $assetsPath.$this->getId().DIRECTORY_SEPARATOR.$this->action->getId().'.'.$resourcesType;

        foreach ($resourcesMap as $path) {
            if (!file_exists($path)) {
                continue;
            }
            $path = \Yii::app()->assetManager->publish($path);
            switch ($resourcesType) {
                case 'js':
                    \Yii::app()->clientScript->registerScriptFile($path);
                    break;

                case 'css':
                    \Yii::app()->clientScript->registerCssFile($path);
                    break;
            }
        }
    }

    /**
     * Регистрирует перечисленные API гугла
     * @return array Массив с различными API. Например
     * ['visualization' =>
     *  'version' => '1.0',
     *  'options' => [
     *    'packages' => ['corechart']
     *  ]
     * ] для графиков
     */
    protected function registeredGoogleApis()
    {
        return [];
    }

    /**
     * @inheritdoc
     * @param bool|false $skipInit
     */
    public function createWidget($className, $properties = [], $skipInit = false)
    {
        $widget = \Yii::app()->getWidgetFactory()->createWidget($this, $className, $properties);
        if (!$skipInit) {
            $widget->init();
        }
        return $widget;
    }

}