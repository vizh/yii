<?php
class Registry
{
  const ApplicationPay = 'pay';
  const ApplicationApi = 'api';
  const ApplicationMobile = 'mobile';

  const Encoding = 'utf-8';

  /**
  * @var Registry
  */
  private static $instance = null;
  
  /**
  * Переменные
  * 
  * @var array
  */
  private $variables = array();
  /**
  * Входящие параметры
  * 
  * @var array
  */
  private $request = array();
  /**
  * Текстовые константы для view контроллера
  * 
  * @var array
  */
  private $words = array();
  
  /**
  *  Позволяет скрыть конструктор для реализации Синглтона
  */
  private function __construct()
  {      
  }
  /**
  *  @return Registry
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
  /**
  * Инициализация синглтона
  * @return void
  */
  private function init()
  {
    $this->setUpVariables();
  }
  
  /**
  * Set up settings
  *
  * @return    void
  * @access    protected
  */
  protected function setUpVariables()
  {    
    $this->variables['cpDirectory'] = 'admin';
    $this->variables['area'] = strpos( Registry::GetEnv('REQUEST_URI'), 
      '/' . $this->variables['cpDirectory'] ) === 0 ? 'admin' : 'public';
      
    $this->variables['MagicQuotes'] = define( 'IPS_MAGIC_QUOTES', @get_magic_quotes_gpc() );
    
    $this->variables['PublicPath'] = $_SERVER['DOCUMENT_ROOT'];
    $this->variables['UserPhotoDir'] = '/files/photo/';
    $this->variables['CompanyLogoDir'] = '/files/logo/';
    $this->variables['EventDir'] = '/files/event/';
    $this->variables['NewsTapeDir'] = '/files/news/tape/';
    $this->variables['NewsPromoDir'] = '/files/news/promo/';
    $this->variables['NewsPartnerDir'] = '/files/news/partner/';
    $this->variables['VideoThumbnailsDir'] = '/files/video/thumbnails/';
    $this->variables['NewsCoverDir'] = '/files/rocid-cover/';
    
    $this->variables['debug'] = true;
    
//    //Attachement Settings
//    $this->settings['MaxFileSize'] = 2048000;
//    $this->settings['SavePath'] = '../files';
  }
  
  /**
  * @return string Идентификатор приложения
  */
  public static function GetId()
  {
    return 'rocid';
  }
  /**
  * @return CDbConnection Создание подключения к базе данных
  */
  public static function GetDb()
  {
    return Yii::app()->getDb();
  }
  
  /**
  * @return ICache Создание объекта, для кеширования данных 
  */
  public static function GetCache()
  {
    return Yii::app()->getCache();
  }

  /**
   * @static
   * @return CHttpSession
   */
  public static function GetSession()
  {
    return Yii::app()->getSession();
  }
  
  /**
  * Внешний геттер для массива $variables
  * @var string $key Ключ массива $variables
  * @return mixed Содержимое элемента массива или null
  */
  public static function GetVariable($key)
  {
    if (isset(self::GetInstance()->variables[$key]))
    {
      return self::GetInstance()->variables[$key];
    }
    else
    {
      return null;
      //throw new Exception("Ключ '$key' не найден в массиве variables");
    }
  }
  /**
  * Внешний сеттер для массива $variables
  * @param string $key Ключ массива $variables
  * @param mixed $value Новое значение элемента
  */
  public static function SetVariable($key, $value)
  {
    self::GetInstance()->variables[$key] = $value;
  }
  
  public static function IsSetVariable($key)
  {
    return isset(self::GetInstance()->variables[$key]);
  }
  
  /**
  * Внешний геттер для массива $request
  * @param string $key
  * @return mixed Содержимое элемента массива или null
  */
  public static function GetRequestVar($key, $defaultValue = null)
  {
    return Yii::app()->getRequest()->getParam($key, $defaultValue);
  }
  
  public static function SetWords($words)
  {
    self::GetInstance()->words = $words;
  }
  
  public static function GetWords()
  {
    return self::GetInstance()->words;
  }
  
  public static function GetWord($key)
  {
    return isset(self::GetInstance()->words[$key]) ? self::GetInstance()->words[$key] : '';    
  }
  
  
  /**
  * Возвращает значение переменно окружения по ключу
  * Абстрактный слой, позволяющий использовать $_SERVER или getenv()
  *
  * @param string $key Ключ переменной окружения
  * @return string
  */
  public static function GetEnv($key)
  {
    $return = array();
    if (is_array( $_SERVER ) && count( $_SERVER ))
    {
      if( isset( $_SERVER[$key] ) )
      {
        $return = $_SERVER[$key];
      }
    }
    if (! $return)
    {
      $return = getenv($key);
    }
    return $return;
  }

  private static $hostsMap = array();
  /**
   * @static
   * @param string[] $hosts
   * @param string $rootPath
   * @param string $defaultCommandClass
   * @return void
   */
  public static function AddHosts($hosts, $rootPath, $defaultCommandClass)
  {
    foreach ($hosts as $host)
    {
      self::$hostsMap[$host] = array($rootPath, $defaultCommandClass);
    }
  }

  /**
   * @static
   * @return string|null
   */
  public static function GetAppPath()
  {
    $host = mb_strtolower($_SERVER['HTTP_HOST'], 'utf-8');
    return isset(self::$hostsMap[$host]) ? self::$hostsMap[$host][0] : null;
  }

  public static function GetDefaultCommandClass()
  {
    $host = mb_strtolower($_SERVER['HTTP_HOST'], 'utf-8');
    return isset(self::$hostsMap[$host]) ? self::$hostsMap[$host][1] : 'DefaultCommand';
  }

  /**
   * @static
   * @param $app
   * @return string
   */
  public static function GetHost($application)
  {
    foreach (self::$hostsMap as $host => $app)
    {
      if (stristr($host, ROCID_HOST) !== false && $app == $application)
      {
        return $host;
      }
    }
    return ROCID_HOST;
  }

  /**
  * Возвращает путь к модулю
  * 
  * @param string $module
  * @return string
  */
  public static function GetModulePath($module)
  {
    return AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . $module;
  }
  
  /**
  * Возвращает путь к source модуля
  * 
  * @param string $module
  * @return string
  */
  public static function GetSourcePath($module)
  {
    return Registry::GetModulePath($module) . DIRECTORY_SEPARATOR . AutoLoader::SourcePath;
  }
}
