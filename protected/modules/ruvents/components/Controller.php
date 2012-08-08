<?php
namespace ruvents\components;

class Controller extends \application\components\controllers\BaseController
{
  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array(
        'accessControl'
      )
    );
  }

  protected function setHeaders()
  {
    //header('Content-type: text/json; charset=utf-8');
    header('Content-type: text/html; charset=utf-8');
  }

  /** @var AccessControlFilter */
  private $accessFilter;
  public function getAccessFilter()
  {
    if (empty($this->accessFilter))
    {
      $this->accessFilter = new AccessControlFilter();
      $this->accessFilter->setRules($this->accessRules());
    }
    return $this->accessFilter;
  }

  public function filterAccessControl($filterChain)
  {
    $this->getAccessFilter()->filter($filterChain);
  }

  public function accessRules()
  {
    $rules = \Yii::getPathOfAlias('ruvents.rules').'.php';
    return require($rules);
  }
}
