<?php
class SearchManager
{
  /**
  * Возвращает отображающий модуль соответствующего плагина
  * 
  * @param string $module
  * @return ISearchDisplay
  */
  public static function GetSearchDisplay($module = '')
  {
    if (empty($module))
    {
      $module = Registry::GetRequestVar('module');
    }
    $module = strtolower($module);
    $sourcePath = $module . '.' . AutoLoader::SourcePath;
    $searchDisplay = ucfirst($module) . 'SearchDisplay';
    $searchDisplayImport = $sourcePath . '.' . $searchDisplay;
    
    AutoLoader::Import($searchDisplayImport, true);
    if (class_exists($searchDisplay))
    {
      $search = new ReflectionClass($searchDisplay);
      if ($search->implementsInterface('ISearchDisplay'))
      {
        return $search->newInstance();
      }
      else
      {
        throw new Exception('Класс отображения результатов поиска не реализует интерфей ISearchDisplay');
      }
    }
    else
    {
      throw new Exception('Класс отображения результатов поиска не найден');
    }    
  }
  
  /**
  * Возвращает поисковой модуль соответствующего плагина
  * 
  * @param string $module
  * @return ISearchPlugin
  */
  public static function GetSearchPlugin($module = '')
  {
    if (empty($module))
    {
      $module = Registry::GetRequestVar('module');
    }
    $module = strtolower($module);
    $sourcePath = $module . '.' . AutoLoader::SourcePath;
    $searchPlugin = ucfirst($module) . 'SearchPlugin';
    $searchPluginImport = $sourcePath . '.' . $searchPlugin;
    
    AutoLoader::Import($searchPluginImport, true);
    if (class_exists($searchPlugin))
    {
      $search = new ReflectionClass($searchPlugin);
      if ($search->implementsInterface('ISearchPlugin'))
      {
        return $search->newInstance();
      }
      else
      {
        throw new Exception('Класс поиска не реализует интерфей ISearchPlugin');
      }
    }
    else
    {
      throw new Exception('Класс поиска не найден');
    }
  }
  
  public static function ModuleSerchable($module)
  {
    $module = strtolower($module);
    $sourcePath = $module . '.' . AutoLoader::SourcePath;
    $searchPlugin = ucfirst($module) . 'SearchPlugin';
    $searchDisplay = ucfirst($module) . 'SearchDisplay';
    $searchPluginImport = $sourcePath . '.' . $searchPlugin;
    $searchDisplayImport = $sourcePath . '.' . $searchDisplay;
    
    AutoLoader::Import($searchPluginImport, true);
    if (class_exists($searchPlugin))
    {
      $search = new ReflectionClass($searchPlugin);
      if (! $search->implementsInterface('ISearchPlugin'))
      {
        return false;
      }
    }
    else
    {
      return false;
    }
    
    AutoLoader::Import($searchDisplayImport, true);
    if (class_exists($searchDisplay))
    {
      $search = new ReflectionClass($searchDisplay);
      if (! $search->implementsInterface('ISearchDisplay'))
      {
        return false;
      }
    }
    else
    {
      return false;
    }
      
    return true;
  }  
}
