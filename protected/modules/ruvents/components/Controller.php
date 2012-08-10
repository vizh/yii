<?php
namespace ruvents\components;

class Controller extends \application\components\controllers\BaseController
{
  const MaxResult = 500;

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

  /**
   * @return \ruvents\models\Operator
   */
  public function Operator()
  {
    return \ruvents\components\WebUser::Instance()->getOperator();
  }

  protected $dataBuilder = null;

  /**
   * @return DataBuilder
   */
  public function DataBuilder()
  {
    if ($this->dataBuilder == null)
    {
      $this->dataBuilder = new DataBuilder($this->Operator()->EventId);
    }

    return $this->dataBuilder;
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