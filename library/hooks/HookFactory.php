<?php
class HookFactory implements ISettingable
{
  /**
  * Возвращает массив вида:
  * array('name1'=>array('DefaultValue', 'Description'), 
  *       'name2'=>array('DefaultValue', 'Description'), ...)
  */
  public function GetSettingList()
  {
    return array('HooksPath' => array('hooks', 'Путь к папке с хуками в данном модуле'));
  }
  
  private static $baseHook = null;
  /**
  * Находит и создает Hook, по указанному модулю и имени.
  * Формат запроса: <Имя модуля>.<имя хука>
  * 
  * @param string $name
  * @return AbstractHook
  */
  public static function GetHook($name)
  {
    //Создает маску класса, если еще не создана
    if (self::$baseHook === null)
    {
      self::$baseHook = new ReflectionClass('AbstractHook');
    }    
    $parts = preg_split('/\//', $name, -1, PREG_SPLIT_NO_EMPTY);
    //Задано только имя "зацепки"
    if (sizeof($parts) === 1)
    {
      $module = SettingManager::GetSetting('DefaultModule');
      $name = $parts[0];
    }
    //Задано имя и модуль зацепки
    elseif (sizeof($parts) === 2)
    {      
      $module = $parts[0];
      $name = $parts[1];
    }
    else
    {
      throw new Exception("Неверный формат имени \"Зацепки\" $name");
    }
    $path = AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . $module
      . DIRECTORY_SEPARATOR . SettingManager::GetSetting('HooksPath')
      . DIRECTORY_SEPARATOR . $name . '.php';
    $import = $module . '.' . SettingManager::GetSetting('HooksPath') . '.' . $name;
    //Если существует класс "зацепки" - создаем его
    if (file_exists($path))
    {
      AutoLoader::Import($import);
      $hookClass = new ReflectionClass($name);
      if ($hookClass->isSubclassOf(self::$baseHook))
      {
        
        return $hookClass->newInstance($name, $module);
      }
      else
      {
        throw new Exception("\"Зацепка\" $module.$name не является AbstractHook ");
      }
    }
    //Иначе, создаем дефолтную
    else
    {
      return new DefaultHook();
    }
    
  }
}