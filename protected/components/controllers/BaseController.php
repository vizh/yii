<?php
namespace application\components\controllers;

class BaseController extends \CController
{
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

  protected function initResources()
  {

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
}
