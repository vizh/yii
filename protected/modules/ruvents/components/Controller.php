<?php
namespace ruvents\components;

class Controller extends \application\components\controllers\BaseController
{
  const MaxResult = 1000;

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

  /** @var \ruvents\models\DetailLog */
  protected $detailLog;

  /**
   * @return \ruvents\models\DetailLog
   */
  public function getDetailLog()
  {
    return $this->detailLog;
  }

  protected function beforeAction($action)
  {
    if (parent::beforeAction($action))
    {
      \Yii::app()->language = 'ru';
      if ($this->getOperator() !== null)
      {
        $this->detailLog = new \ruvents\models\DetailLog();
        $this->detailLog->OperatorId = $this->getOperator()->Id;
        $this->detailLog->EventId = $this->getOperator()->EventId;
        $this->detailLog->Controller = $this->getId();
        $this->detailLog->Action = $action->getId();
      }
      return true;
    }
    return false;
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

  /**
   * @return \ruvents\models\Operator
   */
  public function getOperator()
  {
    return \ruvents\components\WebUser::Instance()->getOperator();
  }

  protected $dataBuilder = null;

  /**
   * @return DataBuilder
   */
  public function getDataBuilder()
  {
    if ($this->dataBuilder == null)
    {
      $this->dataBuilder = new DataBuilder($this->getOperator()->EventId);
    }

    return $this->dataBuilder;
  }

  private $suffixLength = 4;

  protected function getPageToken($offset)
  {
    $prefix = substr(base64_encode($this->getId() . $this->getAction()->getId()), 0, $this->suffixLength);
    return $prefix . base64_encode($offset);
  }

  /**
   * @param string $token
   * @throws Exception
   * @return array
   */
  protected function parsePageToken($token)
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