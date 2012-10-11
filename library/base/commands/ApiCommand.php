<?php
AutoLoader::Import('library.rocid.api.*');

abstract class ApiCommand extends AbstractCommand
{
  const MaxResult = 200;

  /**
   * @var ApiAccount
   */
  protected $Account = null;

  /**
   * @var ApiDataBuilder
   */
  //protected $DataBuilder = null;

  protected function preExecute()
  {
    parent::preExecute();
    header('Content-type: text/json; charset=utf-8');
    //header('Content-type: text/html; charset=utf-8');

    $apiKey = Registry::GetRequestVar('ApiKey');
    $this->Account = ApiAccount::GetByApiKey($apiKey);

    if ($this->Account == null)
    {
      throw new ApiException(101);
    }
    $this->processCheckAccess();
    if ($this->Account->EventId == null)
    {
      $this->Account->EventId = Registry::GetRequestVar('EventId', null);
    }

    if (!$this->Account->CheckAccess())
    {
      throw new ApiException(104);
    }
  }

  protected function processCheckAccess()
  {
    $hash = Registry::GetRequestVar('Hash');
    $timestamp = Registry::GetRequestVar('Timestamp');
    $ip = $_SERVER['REMOTE_ADDR'];
    
    if (!$this->Account->CheckHash($hash, $timestamp))
    {
      throw new ApiException(102);
    }
    if ($this->Account->EventId != null && !$this->Account->CheckIp($ip))
    {
      throw new ApiException(103);
    }
  }

  public final function execute()
  {
    try
    {
      parent::execute();
    }
    catch(ApiException $e)
    {
      $this->sendError($e);
    }
    $this->createLog();
  }


  protected function postExecute()
  {
    parent::postExecute();
  }

  /**
   * @param ApiException $e
   */
  private function sendError($e)
  {
    $this->SendJson((object) array(
      'Error' => true,
      'Code' => $e->getCode(),
      'Message' => $e->getMessage()
    ));
  }

  protected function SendJson($obj)
  {
    echo json_encode($obj);
  }

  private function createLog()
  {
    $log = new ApiLog();
    $log->AccountId = $this->Account != null ? $this->Account->AccountId : null;
    $route = RouteRegistry::GetInstance();
    $log->Target = $route->GetModule() . ':' . $route->GetSection() . ':' . $route->GetCommand();
    $log->Request = serialize($_REQUEST);
    $log->ExecutionTime = Yii::getLogger()->getExecutionTime();

    if (!empty($this->Account) && $this->Account->AccountId == 5)
    {
      $logs = Yii::getLogger()->getProfilingResults();
      ob_start();
      print_r($logs);
      $log->ExecutionData = ob_get_clean();
    }

    $log->save();
  }

  private $suffixLength = 4;

  protected function GetPageToken($offset)
  {
    $route = RouteRegistry::GetInstance();
    $prefix = substr(base64_encode($route->GetModule() . $route->GetSection() . $route->GetCommand()), 0, $this->suffixLength);
    return $prefix . base64_encode($offset);
  }

  /**
   * @param $token
   * @return array
   */
  protected function ParsePageToken($token)
  {
    if (strlen($token) < $this->suffixLength+1)
    {
      throw new ApiException(111);
    }
    $token = substr($token, $this->suffixLength, strlen($token) - $this->suffixLength);

    $result = intval(base64_decode($token));
    if ($result === 0)
    {
      throw new ApiException(111);
    }
    return $result;
  }
}
