<?php
AutoLoader::Import('library.rocid.pay.managers.*');
AutoLoader::Import('library.rocid.pay.systems.*');

class SystemRouter
{
  public static $SystemNames = array(/*'ChronoPay',*/ 'PayOnline', 'Robokassa', 'Test', 'PayPal');
  const Suffix = 'System';

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
   * @var BaseSystem
   */
  private $system;

  private function init()
  {
    foreach (self::$SystemNames as $name)
    {
      $className = $name . self::Suffix;
      if (!class_exists($className))
      {
        throw new PayException('Not exist class: ' . $className, 101);
      }
      $this->system = new $className();
      if ($this->system->Check())
      {
        return;
      }
      $this->system = null;
    }
    throw new PayException('Not find payment system for request', 102);
  }

  public function ParseSystemCallback()
  {
    try
    {
      $this->system->FillParams();
      $this->system->ParseSystem();
      self::LogSuccess();
    }
    catch (PayException $e)
    {
      self::LogError($e->getMessage(), $e->getCode());
    }
    $this->system->EndParseSystem();
  }

  /**
   * Логгирует возникающие ошибки
   * @param string $message
   * @param string $code
   * @return void
   */
  public static function LogError($message, $code)
  {
    $log = new PayLog();
    $log->Message = $message;
    $log->Code = $code;
    if (! empty(self::$instance->system))
    {
      $log->Info = self::$instance->system->Info();
      $log->OrderId = self::$instance->system->OrderId();
      $log->Total = self::$instance->system->Total();
    }
    else
    {
      ob_start();
      print_r($_REQUEST);
      $log->Info = ob_get_clean();
    }
    $log->PaySystem = get_class(self::$instance->system);
    $log->Type = PayLog::TypeError;
    $log->save();
  }

  public static function LogSuccess()
  {
    echo '123';
    $log = new PayLog();
    $log->Message = 'Success payment';
    $log->Info = self::$instance->system->Info();
    $log->PaySystem = get_class(self::$instance->system);
    $log->OrderId = self::$instance->system->OrderId();
    $log->Total = self::$instance->system->Total();
    $log->Type = PayLog::TypeSuccess;
    $log->save();
  }
}