<?php
namespace ruvents\components;

class Controller extends \CController
{
  private $useLog = true;

  public function setUseLog($userLog)
  {
    $this->useLog = $userLog;
  }

  public function getIsUseLog()
  {
    return $this->useLog;
  }

  /**
   * Маппинг не только GET параметров свойствам экшенов, но и POST
   * @return array
   */
  public function getActionParams()
  {
    return array_merge($_GET, $_POST);
  }

  public function filters()
  {
    return ['accessControl'];
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
      if ($this->getAccount() != null)
      {
        $this->detailLog = new \ruvents\models\DetailLog();
        if ($this->getOperator() !== null)
        {
          $this->detailLog->OperatorId = $this->getOperator()->Id;
        }
        $this->detailLog->EventId = $this->getAccount()->EventId;
        $this->detailLog->Controller = $this->getId();
        $this->detailLog->Action = $action->getId();
      }
      return true;
    }
    return false;
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
   * @return \ruvents\models\Account
   */
  public function getAccount()
  {
    return \ruvents\components\WebUser::Instance()->getAccount();
  }

  /**
   * @return \ruvents\models\Operator
   */
  public function getOperator()
  {
    return \ruvents\components\WebUser::Instance()->getOperator();
  }

  protected $event = null;

  /**
   * @return \event\models\Event
   * @throws Exception
   */
  public function getEvent()
  {
    if ($this->event === null)
    {
      $this->event = $this->getAccount()->Event;
      if ($this->event === null)
      {
        throw new \ruvents\components\Exception(301);
      }
    }
    return $this->event;
  }

  protected $dataBuilder = null;

  /**
   * @return DataBuilder
   */
  public function getDataBuilder()
  {
    if ($this->dataBuilder == null)
    {
      $this->dataBuilder = new DataBuilder($this->getAccount()->EventId);
    }

    return $this->dataBuilder;
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

  /**
   * Кодирует данные в JSON формат.
   * Данные преобразуются в JSON формат, вставляются в layout текущего констроллера и отображаются.
   * @param mixed $data данные, которые будут преобразованы в JSON
   */
  public function renderJson($data)
  {
    // Рендер JSON
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

    // Оставим за разработчиком право обернуть возвращаемый JSON глобальным JSON объектом
    if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
      $json = $this->renderFile($layoutFile, array('content' => $json), true);

    header('Content-type: application/json; charset=utf-8');
    echo $json;
  }

  protected function afterAction($action)
  {
    if ($this->getIsUseLog())
    {
      $this->createLog();
    }
    parent::afterAction($action);
  }

  /**
   * @return \ruvents\models\Log
   */
  public function createLog()
  {
    $log = new \ruvents\models\Log();
    if ($this->getAccount() !== null)
    {
      $log->EventId = $this->getAccount()->EventId;
      if ($this->getOperator() !== null)
      {
        $log->OperatorId = $this->getOperator()->Id;
      }
    }
    $log->Route = $this->getId() . '.' . $this->getAction()->getId();
    $log->Params = json_encode($_REQUEST, JSON_UNESCAPED_UNICODE);
    $log->FullTime = \Yii::getLogger()->getExecutionTime();
    $log->save();
    return $log;
  }
}