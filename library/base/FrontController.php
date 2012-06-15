<?php
class FrontController
{
  /**
  * @var FrontController
  */
  private static $instance = null;
  /**
  * @var Registry
  */
  private $registry = null;
  /**
  * @var AbstractCommand    
  */
  private $command = null;

  /**
  *  Позволяет скрыть конструктор для реализации Синглтона
  */
  private function __construct()
  {      
  }
  /**
  * @return FrontController 
  */
  public static function GetInstance()
  {
    if (! self::$instance)
    {
      self::$instance = new self();
      self::$instance->init();      
    }
    return self::$instance;
  }
  
  protected function init()
  {
    $this->registry = Registry::GetInstance();
  }
  /**
  * Обрабатывает входящий запрос используя CommandResolver
  * @return void 
  */
  protected function HandleRequest()
  {
    $cmdResolver = new CommandResolver();
    $this->command = $cmdResolver->GetCommand();      
    $this->command->execute();
  }
  
  public function Run()
  {
    $this->HandleRequest();
  }
  /**
  *  Позволяет скрыть клонирование объекта для реализации Синглтона
  */
  private function __clone()
  {      
  }

  /**
   * @return AbstractCommand|null
   */
  public function Command()
  {
    return $this->command;
  }
}
