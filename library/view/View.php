<?php
/**
 * @throws Exception
 *
 * @method HeadScript HeadScript(array $params)
 * @method HeadStyle HeadStyle(array $params)
 * @method HeadLink HeadLink(array $params)
 * @method HeadMeta HeadMeta(array $params)
 */
class View
{

  private static $appTemplatesPath;
  /**
   * Путь к шаблонам, зависит от того мобильная версия или обычная
   * @return string
   */
  public static function AppTemplatesPath()
  {
    if (! isset(self::$appTemplatesPath))
    {
      $path = Registry::GetAppPath();
      if ($path !== null)
      {
        self::$appTemplatesPath = '..' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . 'templates';
      }
      else
      {
        self::$appTemplatesPath = '..' . DIRECTORY_SEPARATOR . 'templates';
      }
    }

    return self::$appTemplatesPath;
  }

  private static $defaultTemplatesPath;
  public static function DefaultTemplatesPath()
  {
    if (! isset(self::$defaultTemplatesPath))
    {
      self::$defaultTemplatesPath = '..' . DIRECTORY_SEPARATOR . 'templates';
    }

    return self::$defaultTemplatesPath;
  }

  /**
   * Путь к глобальным шаблонам, зависит от того мобильная версия или обычная
   * @param bool $default
   * @return string
   */
  public static function LayoutPath($default = false)
  {
    if ($default)
    {
      return self::DefaultTemplatesPath() . DIRECTORY_SEPARATOR . 'layouts';
    }

    return self::AppTemplatesPath() . DIRECTORY_SEPARATOR . 'layouts';
  }

  /**
   * Массив для магического метода __call
   * В нем хранятся экземпляры классов Head<*****>
   *
   * @var array
   */
  private $heads = array();
  /**
   * Массив для магических методов __get, __set
   *
   * @var array
   */
  private $values = array();
  /**
   * Шаблон данного View
   *
   * @var string
   */
  private $template = null;
  /**
   * Текстовые константы для view контроллера
   *
   * @var array
   */
  private $words = array();

  private static $templateCache = array();

  private $layout = null;
  private $layoutName = null;
  private $useLayout = false;

  private $templatePath = '';

  /**
   * Результат заполнения $template данными
   *
   * @var string
   */
  private $Content = '';

  /**
   * Добавляет темплейт в кеш
   *
   * @param string $path
   * @param string $template
   */
  private static function addToCache($path, $template)
  {
    self::$templateCache[$path] = $template;
  }
  /**
   * Конструктор класса View
   *
   * @param string $path Или имя шаблона - тогда грузится исходя из текущих module,
   * section, command. Или путь к шаблону, тогда берется из templates
   * @return View
   */
  public function __construct()
  {
    $this->heads['AbstractHead'] = '';
    $this->heads['HeadTitle'] = '';
    $this->heads['HeadLink'] = '';
    $this->heads['HeadMeta'] = '';
    $this->heads['HeadScript'] = '';
    $this->heads['HeadStyle'] = '';

    $this->words = Registry::GetWords();
  }

  /**
   * Создает следующие виртуальные методы
   * HeadTitle()
   * HeadLink()
   * HeadMeta()
   * HeadScript()
   * HeadStyle()
   *
   * @param mixed $name
   * @param mixed $args
   * @return AbstractHead
   */
  public function __call($name, $args)
  {
    if (isset($this->heads[$name]))
    {
      if (empty($this->heads[$name]))
      {
        $headClass = new ReflectionClass($name);
        if (empty($this->heads['AbstractHead']))
        {
          $this->heads['AbstractHead'] = new ReflectionClass('AbstractHead');
        }
        if ($headClass->isSubclassOf($this->heads['AbstractHead']))
        {
          $this->heads[$name] = $headClass->newInstance();
        }
        else
        {
          throw new Exception("Метод $name не найден в классе View");
        }
      }
      if (! empty($args))
      {
        $this->heads[$name]->Add($args[0]);
      }
      return $this->heads[$name];
    }
    else
    {
      throw new Exception("Метод $name не найден в классе View");
    }
  }
  /**
   * Магический метод __get
   * Позволяет получать установленные методом __set поля объекта
   *
   * @param string $name
   * @return mixed
   */
  public function __get($name)
  {
    if (isset($this->values[$name]))
    {
      return $this->values[$name];
    }
    else
    {
      return '';
      //throw new Exception("Поле с именем $name не найдено.");
    }
  }
  /**
   * Магический метод set
   * Позволяет устанавливать любые поля объекта
   *
   * @param string $name
   * @param mixed $value
   */
  public function __set($name, $value)
  {
    $this->values[$name] = $value;
  }

  /**
   * Машический метод isset
   * @param string $name
   * @return bool
   */
  public function __isset($name)
  {
    return isset($this->values[$name]);
  }

  /**
   * Рендеринг ответа пользователю
   *
   * @return Возвращает отрендереное содержимое объекта View
   */
//  public function __toString()
//  {
//    $this->template = $this->loadTemplate();
//    
//    if ($this->template !== null)
//    {
//      eval('$out = "' . $this->template . '";');
//      $this->Content = $out;
//    }
//    if ($this->useLayout)
//    {
//      if ($this->layout === null)
//      {
//        $this->SetLayout('default');
//      }
//      eval('$out = "' . $this->layout . '";');
//      $this->Content = $out;
//    }
//    return $this->Content;
//  }

  public function __toString()
  {
    ob_start();
    $templatePath = $this->getFullTempletePath();
    include $templatePath;
    $this->Content = ob_get_clean();

    if ($this->useLayout)
    {
      ob_start();
      $layoutPath = self::LayoutPath() . DIRECTORY_SEPARATOR . $this->layoutName . '.php';
      if (file_exists($layoutPath))
      {
        include $layoutPath;
      }
      else
      {
        $layoutPath = self::LayoutPath(true) . DIRECTORY_SEPARATOR . $this->layoutName . '.php';
        include $layoutPath;
      }
      $this->Content = ob_get_clean();
    }
    return $this->Content;
  }

  /**
   * Загружает макет выводимой страницы
   *
   * @param string $name Имя макета
   */
  public function SetLayout($name)
  {
    $this->layoutName = $name;
    return;

    $fullPath = self::LayoutPath() . DIRECTORY_SEPARATOR . $name . '.phtml';
    if (file_exists($fullPath))
    {
      $this->layout = file_get_contents($fullPath);
    }
    else
    {
      throw new Exception("Файл макета $fullPath не найден");
    }
    $this->layout = addcslashes($this->layout, '"');
  }

  /**
   * Выставляет флаг, используется макет при рендеринге или нет
   *
   * @param bool $isUse
   */
  public function UseLayout($isUse)
  {
    $this->useLayout = $isUse;
  }

  /**
   * Устанавливает шаблон для рендеринга данного View
   * @param string $name Если содержит разделитель директории, то загружается по данному пути, иначе ищет соответствующий шаблон по заданным module, command, section
   * @param string $module Если не задан, то загружает из Registry текущий модуль
   * @param string $command Если не задан, то загружает из Registry текущую команду
   * @param string $section Если не задан, то загружает из Registry текущую секцию
   */
  public function SetTemplate($name, $module = null, $command = null, $section = null, $sectionDir = '')
  {
    if (strstr($name, DIRECTORY_SEPARATOR) !== false)
    {
      $this->templatePath = $name;
    }
    else
    {
      $routeRegistry = RouteRegistry::GetInstance();

      $module = strtolower($module === null ? $routeRegistry->GetModule() : $module);
      $command = strtolower($command === null ? $routeRegistry->GetCommand() : $command);
      $section = strtolower($section === null ? $routeRegistry->GetSection() : $section);
      $name = strtolower($name);

      if (! empty($sectionDir))
      {
        $filePath = $module . DIRECTORY_SEPARATOR . $sectionDir;
      }
      else
      {
        $filePath = $module . DIRECTORY_SEPARATOR . RouteRegistry::GetInstance()->SectionsDir;
      }
      if (! empty($section))
      {
        $filePath .= DIRECTORY_SEPARATOR . $section;
      }
      //      if ($name !== $command)
      //      {
      $filePath .= DIRECTORY_SEPARATOR . $command;
      $filePath .= DIRECTORY_SEPARATOR . $name;
      //      }
      //      else
      //      {
      //        $filePath .= DIRECTORY_SEPARATOR . $command;
      //      }
      $this->templatePath = $filePath;
    }
  }

  /**
   * @return string
   */
  protected function getFullTempletePath()
  {
    $templatePath = self::AppTemplatesPath() . DIRECTORY_SEPARATOR . $this->templatePath . '.php';
    if (!file_exists($templatePath))
    {
      $templatePath = self::DefaultTemplatesPath() . DIRECTORY_SEPARATOR . $this->templatePath . '.php';
    }

    return $templatePath;
  }

  public function IsExistTemplate()
  {
    return file_exists($this->getFullTempletePath());
  }

  public function SetTemplatePath($templatePath)
  {
    $this->templatePath = $templatePath;
  }
}