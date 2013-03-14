<?php
namespace api\components;

class Controller extends \application\components\controllers\BaseController
{
  protected $result = null;

  public function actions()
  {
    return $this->getVersioningActions();
  }

  /**
   * @return array
   */
  protected function getVersioningActions()
  {
    //$version = \Yii::app()->getRequest()->getParam('v', null);
    //$timestamp = strtotime($version);

    $path = \Yii::getPathOfAlias('api.controllers.'.$this->getId());
    $result = array();

    $files = scandir($path);
    $pattern = '/((\w*?)Action(\d*?)).php$/i';
    foreach ($files as $file)
    {
      if (preg_match($pattern, $file, $matches) === 1)
      {
        //$matches[3] - дата новой версии action
        //todo: даполнить метод версионностью
        $key = strtolower($matches[2]);
        $result[$key] = '\\api\\controllers\\'.$this->getId().'\\'.$matches[1];
      }
    }

    return $result;
  }

  /**
   * @param mixed $result
   */
  public function setResult($result)
  {
    $this->result = $result;
  }


  /**
   * @param \CAction $action
   *
   * @return bool
   */
  protected function beforeAction($action)
  {
    if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
    {
      \Yii::app()->disableOutputLoggers();
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

  public function getPageToken($offset)
  {
    $prefix = substr(base64_encode($this->getId() . $this->getAction()->getId()), 0, $this->suffixLength);
    return $prefix . base64_encode($offset);
  }

  /**
   * @param string $token
   * @throws Exception
   * @return array
   */
  public function parsePageToken($token)
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