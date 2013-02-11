<?php
namespace api\components;

class Controller extends \application\components\controllers\BaseController
{
  protected $result = null;


  /**
   * @param \CAction $action
   *
   * @return bool
   */
  protected function beforeAction($action)
  {
    $routes = \Yii::app()->log->getRoutes();
    foreach ($routes as $route)
    {
      if ($route instanceof \CProfileLogRoute || $route instanceof \CWebLogRoute)
      {
        $route->enabled = false;
      }
    }
    return parent::beforeAction($action);
  }

  /**
   * @param \CAction $action
   */
  public function afterAction($action)
  {
    echo json_encode($this->result);
  }

  const MaxResult = 200;

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
    $rules = \Yii::getPathOfAlias('api.rules').'.php';
    return require($rules);
  }

  /**
   * @return \api\models\Account
   */
  public function Account()
  {
    return \api\components\WebUser::Instance()->getAccount();
  }

  private $suffixLength = 4;

  protected function GetPageToken($offset)
  {
    $prefix = substr(base64_encode($this->getId() . $this->getAction()->getId()), 0, $this->suffixLength);
    return $prefix . base64_encode($offset);
  }

  /**
   * @param string $token
   * @throws Exception
   * @return array
   */
  protected function ParsePageToken($token)
  {
    if (strlen($token) < $this->suffixLength+1)
    {
      throw new Exception(111);
    }
    $token = substr($token, $this->suffixLength, strlen($token) - $this->suffixLength);

    $result = intval(base64_decode($token));
    if ($result === 0)
    {
      throw new Exception(111);
    }
    return $result;
  }
}