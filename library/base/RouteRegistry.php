<?php
AutoLoader::Import('library.rocid.settings.*');
class RouteRegistry
{
  const SectionDirPublic = 'public';
  const SectionDirAdmin = 'admin';

  /**
  * @var RouteRegistry
  */
  private static $instance = null;
  
  private static $routes = array();
  
  private static $routesTree = array();
  
  private $module = '';
  private $section = '';
  private $command = '';
  private $params = array();
  
  public $SectionsDir = self::SectionDirPublic;
  
  /**
  * 
  * @return RouteRegistry
  */
  public static function GetInstance()
  {
    if (self::$instance == null)
    {
      self::$instance = new RouteRegistry();
      self::$instance->init();
    }    
    return self::$instance;
  }
  
  /**
  * Добавляет новый путь
  * @param string $name Имя маршрута
  * @param array $routeInfo Параметры пути
  * Example: array('person/:id', array('module'=>'profile', 'section'=>'', 'command'=>'show'),
  * array('id'=>'/\d+/'))
  * Разбираемый путь, значения по умолчанию, условия на переменные    
  */
  public static function AddRoute($name, $routeInfo)
  {
    $temp = $routeInfo[1];
    if (!empty($temp['module']))
    {
      if (! isset(self::$routesTree[$temp['module']]))
      {
        self::$routesTree[$temp['module']] = array();
      }
      if (!empty($temp['section']))
      {
        if (! isset(self::$routesTree[$temp['module']][$temp['section']]))
        {
          self::$routesTree[$temp['module']][$temp['section']] = array();
        }
        if (!empty($temp['command']))
        {
          if (! isset(self::$routesTree[$temp['module']][$temp['section']][$temp['command']]))
          {
            self::$routesTree[$temp['module']][$temp['section']][$temp['command']] = array();
          }
          self::$routesTree[$temp['module']][$temp['section']][$temp['command']] = $routeInfo;
        }
      }
      else
      {
        if (!empty($temp['command']))
        {
          if (! isset(self::$routesTree[$temp['module']][$temp['command']]))
          {
            self::$routesTree[$temp['module']][$temp['command']] = array();
          }
          self::$routesTree[$temp['module']][$temp['command']] = $routeInfo;
        }
      }
    }
    
    $routeInfo[0] = preg_split('/\//', trim($routeInfo[0], '/'), -1, PREG_SPLIT_NO_EMPTY);
    self::$routes[$name] = $routeInfo;
  }
  
  private function init()
  {
    $this->SectionsDir = (Registry::GetVariable('area') !== self::SectionDirAdmin) ?
        self::SectionDirPublic : self::SectionDirAdmin;
    require_once AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . 'routes.php';
    $this->ParseRoute();
  }
  
  /**
  * Вычисляет совпадение пути с шаблонами и подставляет используемые переменные
  */
  public function ParseRoute()
  {
    $requestUri = Registry::GetEnv('REQUEST_URI');
    $spacerPos = strpos($requestUri, '?');
    $request = $spacerPos ? substr($requestUri, 0, $spacerPos) : $requestUri;        
    if (Registry::GetVariable('area') === self::SectionDirAdmin)
    {
      $request = substr($request, strpos($request, self::SectionDirAdmin) + 5);
    }
    //print_r(array('req' => $request));
    $parts = preg_split('/\//', trim($request, '/'), -1, PREG_SPLIT_NO_EMPTY);
    //print_r($parts);
    foreach(self::$routes as $key => $value)
    {
      if ($this->testRoute($value, $parts))
      {
        $this->fillRegistryRequest($value, $parts);        
        return ;
      }
    }
    //Если не найден предопределенный шаблон, заполняем по дефолту
    $this->fillRegistryDefault($parts);
  }  
  
  /**
  * Проверяет, соответствует ли данный $route переданному $request
  * 
  * @param array $routeInfo
  * @param array $requestParts
  * @return bool true - в случае соответствия, false - иначе
  */
  private function testRoute($routeInfo, $requestParts)
  {    
    //Если в переданном пути запроса больше частей, чем в шаблоне - 
    //сразу отбрасываем такой шаблон    
    if (sizeof($routeInfo[0]) < sizeof($requestParts))
    {      
      return false;
    } 
    //Перебирая части пути сверяем переданный путь запроса с шаблоном
    for($i=0; $i < sizeof($routeInfo[0]); $i++)
    {
      // Если переданный путь короче шаблона - то проверяем установлены ли
      // значения по умолчанию, для отсутствующих частей
      if (empty($requestParts[$i]))
      {
        //Проверяем, является ли данная часть шаблона переменной - если нет
        //переданный путь не соответствует шаблону
        if (substr($routeInfo[0][$i], 0, 1) !== ':')
        {
          return false;
        }
        $varName = substr($routeInfo[0][$i], 1);
        //Проверяем, задано ли значение по умолчанию для переменной
        if (! isset($routeInfo[1][$varName]))
        {
          return false;
        }
      }
      else
      {
        //Если часть пути шаблона не соовпадает с запросом и не является переменной
        //то возвращаем false 
        if ($routeInfo[0][$i] !== $requestParts[$i] 
          && (substr($routeInfo[0][$i], 0, 1) !== ':'))
        {
          return false;
        }
        //Если часть пути шаблона является переменной, то проверяем на соответствие
        //regexp выражению
        elseif (substr($routeInfo[0][$i], 0, 1) === ':')
        {
          $varName = substr($routeInfo[0][$i], 1);          
          if (! empty($routeInfo[2][$varName]))
          {            
            if (! preg_match($routeInfo[2][$varName], $requestParts[$i], $matches)
              || $matches[0] !== $requestParts[$i])
            {
              return false;
            }                      
          }
        }
      }
    }
    return true;
  }
  
  /**
  * Заполняет Registry->$request данными из $requestParts базируясь на данном $route
  * 
  * @param array $routeInfo
  * @param array $requestParts
  */
  private function fillRegistryRequest($routeInfo, $requestParts)
  {
    foreach ($routeInfo[1] as $key => $value)
    {
      $this->setParameter($value, $key);
    }
    
    for($i=0; $i < sizeof($routeInfo[0]); $i++)
    {
      if (substr($routeInfo[0][$i], 0, 1) === ':')
      {
        $varName = substr($routeInfo[0][$i], 1);
        if (! empty($requestParts[$i]))
        {
          $varValue = $requestParts[$i];
          $this->setParameter($varValue, $varName);
        }
        else
        {
          return;
        }
      }
    }    
  }
  
  /**
  * Заполняет Registry->$request данными из $requestParts базируясь на дефолтном маршруте
  * /[:module]/[:section]/[:command]
  * @param mixed $requestParts
  */
  private function fillRegistryDefault($requestParts)
  {
    foreach ($requestParts as $value)
    {
      if (empty($this->module))
      {
        if (! $this->setModule($value))
        {
          return;
        }
      }
      elseif (empty($this->command))
      {
        if (! empty($this->section))
        {
          if (! $this->setCommand($value))
          {
            $cName = $this->section;
            $this->section = '';
            if ($this->setCommand($cName))
            {
              $this->params[] = $value;
            }
            else
            {
              return;
            }            
          }
        }
        elseif (! $this->setSection($value))
        {          
          if (! $this->setCommand($value))
          {
            return;
          }
        }
      }
      else
      {
        $this->params[] = $value;
      }
    }

    if (! empty($this->section) && empty($this->command))
    {
      $this->command = $this->section;
      $this->section = '';
    }
  }
  
  /**
  * Устанавливает имя модуля, если такого модуля нет - то устанавливает дефолтное имя
  * 
  * @param string $name
  * @return string true - если модуль с таким именем существует, и false - иначе
  */
  private function setModule($name)
  {
    $name = strtolower($name);
    if (! empty($name) && file_exists(AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . $name))
    {
      $this->module = $name;
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Устанавливает имя секции, если такой секции нет - то устанавливает дефолтное имя
  * Вызывается только после SetModule
  * @param string $name
  * @return string true - если секция с таким именем существует, и false - иначе
  */
  private function setSection($name)
  {
    $name = strtolower($name);
    $path = AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . $this->module
      . DIRECTORY_SEPARATOR . $this->SectionsDir
      . DIRECTORY_SEPARATOR . $name;
    if (! empty($name) && file_exists($path))
    {
      $this->section = $name;
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Устанавливает имя команды, если такой команды нет - то устанавливает дефолтное имя
  * Вызывается только после SetSection
  * @param string $name
  * @return string true - если секция с таким именем существует, и false - иначе
  */
  private function setCommand($name)
  {
    $fileName = ucfirst(strtolower($this->module));
    $path = AutoLoader::ModulesPath() . DIRECTORY_SEPARATOR . $this->module
      . DIRECTORY_SEPARATOR . $this->SectionsDir;    
    if (! empty($this->section))
    {
      $fileName .= ucfirst(strtolower($this->section));
      $path .= DIRECTORY_SEPARATOR . $this->section;
    }
    $fileName .= ucfirst(strtolower($name));
    $path .= DIRECTORY_SEPARATOR . $fileName . '.php';
    if (! empty($name) && file_exists($path))
    {
      $this->command = $name;
      return true;
    }
    else
    {
      //TODO: Либо загружать дефолтную команду для данного модуля, либо дропать Exception
      return false;
    }
  }  
  
  /**
  * Устанавливает значение входящего параметра, заполняет поля класса module, section, command, params
  * 
  * @param mixed $value
  * @param mixed $name
  */
  private function setParameter($value, $name = '')
  {
    if ($name == 'module')
    {
      $this->module = $value;          
    }
    elseif ($name == 'section')
    {
      $this->section = $value;
    }
    elseif ($name == 'command')
    {
      $this->command = $value;
    }
    else
    {
      if (! empty($name))
      {
        $this->params[$name] = $value;
      }
      else
      {
        $this->params[] = $value;
      }
    }
  }
  
  
  public function GetModule()
  {
    return $this->module;
  }
  
  public function GetSection()
  {
    return $this->section;
  }
  
  public function GetCommand()
  {
    return $this->command;
  }
  
  public function GetParams()
  {
    return $this->params;
  }

  /**
   * @param string $module
   * @param string $section
   * @param string $command
   * @param array $params
   * @param string $application
   * @param string $sectionDir
   * @param string $protocol
   * @return string
   */
  public static function GetUrl($module, $section, $command, $params = array(), $sectionDir = self::SectionDirPublic, $protocol = 'http://')
  {
    $pathInfo = null;
    if (isset(self::$routesTree[$module]))
    {      
      if (! empty($section) && isset(self::$routesTree[$module][$section]))
      {
        if (isset(self::$routesTree[$module][$section][$command]))
        {
          $pathInfo = self::$routesTree[$module][$section][$command];
        }
      }
      elseif (empty($section))
      {
        if (isset(self::$routesTree[$module][$command]) && isset(self::$routesTree[$module][$command][0]))
        {
          $pathInfo = self::$routesTree[$module][$command];
        }
      }
    }
    
    $path = '';
    if (! empty($pathInfo))
    {
      $path = $pathInfo[0];
      
      foreach ($params as $key => $value)
      {
        $find = ':'.$key . '/';
        if (strpos($path, $find))
        {
          $path = str_replace($find, $value . '/', $path);
          if (isset($pathInfo[1][$key]))
          {
            unset($pathInfo[1][$key]);
          }
          unset($params[$key]);
        }
      }

      if (! empty($params))
      {
        throw new Exception('Ошибка определения пути к команде!');
      }
      foreach($pathInfo[1] as $key => $value)
      {
        $pos = strpos($path, ':'.$key);
        if ($pos !== false)
        {
          $path = substr($path, 0, $pos);
        }
      }
    }
    else
    {
      $path = '/' . $module . '/';
      if (!empty($section))
      {
        $path .= $section . '/';
      }
      $path .= $command . '/';
      foreach ($params as $param)
      {
        
        $path .= urlencode($param) . '/';
      }
    }

//    if (!empty($application))
//    {
//      $host = Registry::GetHost($application);
//    }
//    else
//    {
//      $host = ROCID_HOST;
//    }
    $host = $_SERVER['HTTP_HOST'];
    if (substr($path, 0, 1) != '/')
    {
      $path = '/' . $path;
    }
    if ($sectionDir == self::SectionDirAdmin)
    {
      $path = '/' . $sectionDir . $path;
    }
    return $protocol . $host . $path;
  }

  public static function GetAdminUrl($module, $section, $command, $params = array(), $protocol = 'http://')
  {
    return self::GetUrl($module, $section, $command, $params, self::SectionDirAdmin, $protocol);
  }
}
