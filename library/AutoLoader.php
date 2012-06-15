<?php

defined('LibraryPath') or define('LibraryPath', dirname(__FILE__));
//defined('ModulesPath') or define('ModulesPath', '..' . DIRECTORY_SEPARATOR . 'application');

class AutoLoader
{
  const LibraryPath = LibraryPath;
  const SourcePath = 'source';
  private static $modulesPath;
  
  public static function ModulesPath($default = false)
  {
    if ($default)
    {
      return '..' . DIRECTORY_SEPARATOR . 'application';
    }

    if (! isset(self::$modulesPath))
    {
      $path = Registry::GetAppPath();
      if ($path !== null)
      {
        self::$modulesPath = '..' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . 'application';
      }
      else
      {
        self::$modulesPath = '..' . DIRECTORY_SEPARATOR . 'application';
      }
    }
    
    return self::$modulesPath;
  }
  
  /**
  * @var array алиас => путь
  */
  private static $aliases = array('library'=>self::LibraryPath);
  /**
  * @var array  алиас => имя класса или директории 
  */
  private static $imports = array(); 
  /**
  * @var array Загруженные классы
  */
  private static $classes = array();
  /**
  * @var array Маппинг классов, входящих в ядро
  */
  private static $coreClasses = array(
    'UserForm' => '/forms/UserForm.php',
    'UserFormElement' => '/forms/UserFormElement.php',

    'IAdminMenu' => '/structure/IAdminMenu.php',
    'Menu' => '/structure/Menu.php',
    'Structure' => '/structure/Structure.php',
    'StructureObject' => '/structure/StructureObject.php',
    'StructureManager' => '/structure/StructureManager.php',
    'CoreMask' => '/structure/CoreMask.php',
    'CoreGroup' => '/structure/CoreGroup.php',
  );
    
  /**
  * Метод обеспечивающий автоматическую загрузку классов.
  * Этот метод замещает собой магический метод __autoload()   
  * @param string $className Имя загружаемого класса
  * @return bool True - если класс загружен успешно, false - иначе
  */
  public static function Autoload($className)
  {
    // Проверяем является ли класс частью ядра, или был импортирован
    if (isset(self::$coreClasses[$className]))
    {
      include_once(self::LibraryPath . self::$coreClasses[$className]);
    }      
    elseif (isset(self::$classes[$className]))
    {
      include_once(self::$classes[$className]);    
    }            
    else
    {
      // Если есть другие загрузчики, то в случае ошибки управление будет передано им
      @include($className . '.php');      
    }
    return class_exists($className, false);
  }
  
  /**
  * Импортирует объявление класса или путь к классу (библиотеке классов) 
  * @param string $alias Путь к импортируемому алиасу
  * @param bool $forceInclude Подключение данного класса немедленно
  * @return string Имя класса или директории, на которые ссылается алиас
  */
  public static function Import($alias, $forceInclude = false)
  {
    // алиас уже был импортирован  
    if (isset(self::$imports[$alias]))  
    {
      return self::$imports[$alias];
    }
    // Класс уже загружен             
    if (class_exists($alias, false))  
    {
      return self::$imports[$alias] = $alias;    
    }
    // Просто имя класса           
    if (isset(self::$coreClasses[$alias]) || ($pos = strrpos($alias, '.')) === false)  
    {
      self::$imports[$alias]=$alias;
      // Подключение немедленно
      if ($forceInclude)
      {
        // Класс ядра  
        if (isset(self::$coreClasses[$alias])) 
        {
          require(self::LibraryPath . self::$coreClasses[$alias]);    
        }           
        else
        {
          require($alias . '.php');    
        }           
      }
      return $alias;
    }
    // Мы не используем множественный импорт и импортируемый класс уже загружен
    if (($className = (string)substr($alias, $pos + 1)) !== '*' && class_exists($className, false))
    {
      return self::$imports[$alias] = $className;    
    }

    $path = self::GetPathOfAlias($alias);    
    // Проверяем, загружаем отдельный класс или множественный импорт
    if ($className !== '*')
    {
      self::$imports[$alias] = $className;
      
      // Подключение немедленно
      if ($forceInclude)
      {        
        require($path . '.php');
      }        
      else
      {
        self::$classes[$className] = $path . '.php';
      }       
      return $className;
    }
    else  // множественный импорт
    {
      set_include_path(get_include_path() . PATH_SEPARATOR . $path);
      return self::$imports[$alias] = $path;
    }
  }
  /**
  * Преобразует алиас в файловый путь 
  * @param string $alias Алиас (например library.db.ar.CActiveRecord, library.base.*)
  * @return string Файловый путь К library или соответствующему модулю
  */
  public static function GetPathOfAlias($alias)
  {
    if (isset(self::$aliases[$alias]))
    {
      return self::$aliases[$alias];  
    }            
    else
    {
      if (strpos($alias, 'library') !== false)
      {
        $tmpAlias = substr($alias, strpos($alias, '.') + 1);
        $path = self::$aliases['library'];
      }
      else
      {
        $tmpAlias = $alias;
        $path = self::ModulesPath(stripos($alias, '*') !== false);
      }
      self::$aliases[$alias] = rtrim($path.DIRECTORY_SEPARATOR.str_replace('.', DIRECTORY_SEPARATOR, $tmpAlias), '*'.DIRECTORY_SEPARATOR);
      return self::$aliases[$alias];    
    }  
  }
  /**
  * Инициализирует автолоадер
  * @return void
  */
  public static function Init()
  {    
    spl_autoload_register(array('AutoLoader', 'Autoload'));  
    AutoLoader::Import('library.base.*');
    AutoLoader::Import('library.base.auth.*');
    AutoLoader::Import('library.base.commands.*');
  }
}
