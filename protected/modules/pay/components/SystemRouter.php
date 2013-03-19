<?php
namespace pay\components;

class SystemRouter
{
  public static $SystemNames = array(/*'ChronoPay',*/ 'PayOnline', 'Robokassa', 'Test', 'PayPal', 'Uniteller');
  const Prefix = 'pay\components\systems\\';

  /**
   * @var SystemRouter
   */
  private static $instance = null;

  public static function Instance()
  {
    if (self::$instance === null)
    {
      self::$instance = new SystemRouter();
      self::$instance->init();
    }

    return self::$instance;
  }

  /**
   * @var \pay\components\systems\Base
   */
  private $system = null;

  private function init()
  {
    foreach (self::$SystemNames as $name)
    {
      $className = self::Prefix . $name;
      if (!class_exists($className))
      {
        throw new Exception('Not exist class: ' . $className, 101);
      }
      /** @var $system \pay\components\systems\Base */
      $system = new $className();
      if ($system->check())
      {
        $this->system = $system;
        return;
      }
    }
    throw new Exception('Not find payment system for request', 102);
  }

  public function parseSystemCallback()
  {
    try
    {
      $this->system->fillParams();
      $this->system->parseSystem();
      self::logSuccess();
    }
    catch (Exception $e)
    {
      self::logError($e->getMessage(), $e->getCode());
    }
    $this->system->endParseSystem();
  }

  /**
   * Логгирует возникающие ошибки
   * @param string $message
   * @param string $code
   * @return void
   */
  public static function LogError($message, $code)
  {
    $log = new \pay\models\Log();
    $log->Message = $message;
    $log->Code = $code;
    if (! empty(self::$instance->system))
    {
      $log->Info = self::$instance->system->Info();
      $log->OrderId = self::$instance->system->getOrderId();
      $log->Total = self::$instance->system->getTotal();
    }
    else
    {
      ob_start();
      print_r($_REQUEST);
      $log->Info = ob_get_clean();
    }
    $log->PaySystem = get_class(self::$instance->system);
    $log->Error = true;
    $log->save();
  }

  public static function LogSuccess()
  {
    $log = new \pay\models\Log();
    $log->Message = 'Success payment';
    $log->Info = self::$instance->system->Info();
    $log->PaySystem = get_class(self::$instance->system);
    $log->OrderId = self::$instance->system->getOrderId();
    $log->Total = self::$instance->system->getTotal();
    $log->Error = false;
    $log->save();
  }
}