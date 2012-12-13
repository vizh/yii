<?php
namespace application\components\controllers;

class BaseController extends \CController
{
  public $layout = '//layouts/public';
  
  public function filters()
  {
    return array('setHeaders', 'initResources');
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
    $this->registerResources('js');
    $this->registerResources('css');
  }
  
  private function registerResources($resourcesType)
  {
    $resourcesMap = array();
    $assetsPath = \Yii::getPathOfAlias('application.modules.'.$this->module->name.'.assets.'.$resourcesType).DIRECTORY_SEPARATOR;
    $modulePath = $assetsPath.'module.'.$resourcesType;
    if (file_exists($modulePath))
      $resourcesMap['module'] = $modulePath;
    
    $controllerPath = $assetsPath.$this->id.DIRECTORY_SEPARATOR.'controller.'.$resourcesType;
    if (file_exists($controllerPath))
      $resourcesMap['controller'] = $controllerPath;
    
    $actionPath = $assetsPath.$this->id.DIRECTORY_SEPARATOR.$this->action->id.'.'.$resourcesType;
    if (file_exists($actionPath))
      $resourcesMap['action'] = $actionPath;
    
    foreach ($resourcesMap as $path)
    {
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
