<?php
class CommandResolver
{
  private $baseCmd;
  private $defaultCmd;
  
  
  public function __construct()
  {
    $this->baseCmd = new ReflectionClass('AbstractCommand');
    $this->defaultCmd = new DefaultCommand();    
  }
  /**
  * Определяет активную команду
  * @return AbstractCommand
  */
  public function GetCommand()
  {
    $routeRegistry = RouteRegistry::GetInstance();
    
    $module = strtolower($routeRegistry->GetModule());
    $section = strtolower($routeRegistry->GetSection());
    $command = strtolower($routeRegistry->GetCommand());
    
    $className = self::GetCommandClassName($module, $section, $command);
    $filepath = self::GetCommandFilePath($module, $section, $className);
    $import = self::GetCommandImport($module, $section, $className);
    
    //Если существует такой файл - пытаемся загрузить
    if (file_exists($filepath))
    {      
      AutoLoader::Import($import, true);
      $cmdClass = new ReflectionClass($className);
      //Если класс является наследником AbstractCommand - создаем экземпляр класса
      if ($cmdClass->isSubclassOf($this->baseCmd))
      {
        return $cmdClass->newInstance();
      }
      else
      {
        throw new Exception("$command в $module не существует!");
      }
    }
    //Если нет - возвращаем дефолтную команду
    else
    {
      return $this->defaultCmd;
    }
  }
  
  /**
  * Возвращает имя класса команды, по модулю, секции и команде
  * 
  * @param string $module
  * @param string $section
  * @param string $command
  * @return string
  */
  public static function GetCommandClassName($module, $section, $command)
  {
    $className = ucfirst($module);
    if (! empty($section))
    {
      $className .= ucfirst($section);
    }
    $className .= ucfirst($command);
    return $className;
  }
  
  /**
  * Возвращает путь к файлу команды, по модулю, секции и имени класса
  * 
  * @param string $module
  * @param string $section
  * @param string $className
  * @return string
  */
  public static function GetCommandFilePath($module, $section, $className)
  {
    $filePath = Registry::GetModulePath($module) . DIRECTORY_SEPARATOR . RouteRegistry::GetInstance()->SectionsDir;
    if (! empty($section))
    {
      $filePath .= DIRECTORY_SEPARATOR . $section;
    }
    $filePath .= DIRECTORY_SEPARATOR . $className . '.php';
    return $filePath;
  }
  
  /**
  * Возвращает импорт строку, по модулю, секции и имени класса
  * 
  * @param string $module
  * @param string $section
  * @param string $className
  * @return string
  */
  public static function GetCommandImport($module, $section, $className)
  {
    $import = $module . '.' .  RouteRegistry::GetInstance()->SectionsDir;
    if (! empty($section))
    {
      $import .= '.' . $section; 
    }
    $import .= '.' . $className;
    return $import;
  }
}