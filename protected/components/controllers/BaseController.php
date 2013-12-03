<?php
namespace application\components\controllers;

abstract class BaseController extends \CController
{
  public function filters()
  {
    return array('validateCsrf', 'setHeaders', 'initResources');
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
    if (in_array($this->getModule()->getId(), \Yii::app()->csrfValidationModules))
    {
      \Yii::app()->request->enableCsrfValidation = true;
      \Yii::app()->request->validateCsrfToken(new \CEvent($this));
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
    $resourcesMap = array();
    $assetsPath = \Yii::getPathOfAlias($this->module->name . '.assets.' . $resourcesType) . DIRECTORY_SEPARATOR;
    $resourcesMap[] = $assetsPath . 'module.' . $resourcesType;
    $resourcesMap[] = $assetsPath . $this->getId() . '.' . $resourcesType;
    $resourcesMap[] = $assetsPath . $this->getId() . DIRECTORY_SEPARATOR . $this->action->getId() . '.' . $resourcesType;

    foreach ($resourcesMap as $path)
    {
      if (!file_exists($path))
      {
        continue;
      }
      $path = \Yii::app()->assetManager->publish($path);
      switch ($resourcesType)
      {
        case 'js':
          \Yii::app()->clientScript->registerScriptFile($path);
          break;
        
        case 'css':
          \Yii::app()->clientScript->registerCssFile($path);
          break;
      }
    }
  }

}