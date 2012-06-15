<?php
class SettingManager
{
  // todo: Если одинаковые имена классов, наступает коллапс. Удалить категорию Admin после имплемента пхп 5.3
  private static $dirExcludeWords = array('Zend', 'admin', 'twitteroauth', 'auth', 'framework');

  private static $settings = null;
  
  private static function getCacheTime()
  {
    return 24 * 60 * 60;
  }
  
  public static function GetCacheKey()
  {
    return 'CacheSettingsKey';
  }
  
  /**
  * Возвращает эдемент настроек
  * 
  * @param string $name
  * @return array На нулевой позиции - значение свойства, на первой - описание
  */
  public static function GetSettingArray($name)
  {
    $settings = self::getCacheSettings();
    return isset($settings[$name]) ? $settings[$name] : null;
  }

  /**
   * @static
   * @param  $name
   * @return null|mixed
   */
  public static function GetSetting($name)
  {
    $setting = self::GetSettingArray($name);    
    return isset($setting[0]) ? $setting[0] : null;
  }
  
  /**
  * Устанавливает значение опции с данным именем
  * 
  * @param string $name
  * @param array|mixed $settingValue
  */
  public static function SetSetting($name, $settingValue)
  {
    $setting = Setting::GetSettingByName($name);
    if (is_array($settingValue) && ! empty($settingValue))
    {
      $setting->SetValue($settingValue[0]);
      if (! empty($settingValue[1]))
      {
        $setting->SetDescription($settingValue[1]);
      }      
    }
    else
    {
      $setting->SetValue($settingValue);
    }
    $setting->save();
    $cache = Registry::GetCache();
    if ($cache !== null)
    {
      $cache->Delete(self::GetCacheKey());
    }
  }
  
  private static function getCacheSettings()
  {
    if (self::$settings === null)
    {      
      $cache = Registry::GetCache();
      if ($cache !== null && $settings = $cache->Get(self::GetCacheKey()))
      {
        self::$settings = $settings;
      }
      else
      {
        $settings = self::loadSettingsFromDb();
        if ($cache !== null)
        {
          $cache->Set(self::GetCacheKey(), $settings, self::getCacheTime());
        }
        self::$settings = $settings;
      }
    }
    
    return self::$settings;
  }
  
  private static function loadSettingsFromDb()
  {
    $settings = Setting::model()->findAll();
    if (sizeof($settings) === 0)
    {
      self::GrabDefaultSettings();
      $settings = Setting::model()->findAll();
    }
    $result = array();
    foreach ($settings as $setting)
    {
      $result[$setting->GetName()] = array($setting->GetValue(), $setting->GetDescription());
    }
    return $result;
  }
  
  public static function GrabDefaultSettings()
  {
    set_time_limit(1000);
    self::recursiveGrabSettings(AutoLoader::LibraryPath, 'library', 0);
    self::recursiveGrabSettings(AutoLoader::ModulesPath(), '', 0);
  }
  
  private static function recursiveGrabSettings($path, $import, $iterate)
  {
    if ($iterate > 10)
    {
      return;
    }
    foreach (self::$dirExcludeWords as $word)
    {
      if (stristr($path, $word) !== false)
      {
        return;
      }
    }
    $dirs = scandir($path);
    foreach ($dirs as $value)
    {      
      if ($value !== '.' && $value !== '..')
      {        
        $tmpDir = $path . DIRECTORY_SEPARATOR . $value;
        $importPart = basename($tmpDir, '.php');
        $tmpImport = empty($import) ? $importPart : $import . '.' . $importPart;

        
        if (is_dir($tmpDir))
        {
          self::recursiveGrabSettings($tmpDir, $tmpImport, $iterate+1);
        }
        elseif (is_file($tmpDir))
        {
          $pathInfo = pathinfo($tmpDir);

          if (isset($pathInfo['extension']) && $pathInfo['extension'] === 'php')
          {
//            if (stristr($tmpDir, 'MainIndex'))
//        {
//          print_r($pathInfo);
//          echo ' ' . $importPart;
//        }
            AutoLoader::Import($tmpImport);            
            $reflectionClass = new ReflectionClass($importPart);
            if ($reflectionClass->implementsInterface('ISettingable') && $importPart != 'ISettingable')
            {
              $instance = $reflectionClass->newInstance();

              self::parseISettingableClass($instance);
            }
          }
        }
      }
    }
  }
  
  /**
  * Загружает в БД все настройки данного класса
  * 
  * @param ISettingable $settingCollection
  */
  private static function parseISettingableClass($settingCollection)
  {
    $settings = $settingCollection->GetSettingList();
    foreach ($settings as $name => $params)
    {
      $setting = new Setting();
      $setting->SetName($name);
      if (isset($params[0]))
      {
        $setting->SetValue($params[0]);
      }
      if (isset($params[1]))
      {
        $setting->SetDescription($params[1]);
      }
      $setting->save();
    }
  }
}
