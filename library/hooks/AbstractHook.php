<?php
abstract class AbstractHook
{
  protected $view;
  /**
  * Конструктор
  * создает объект View, если задано имя "зацепки"
  * 
  * @param string $name
  * @param string $module
  * @return AbstractHook
  */
  public function __construct()
  {    
    $this->init();
  }
  
  public function init($name = '', $module = '')
  {
    if (empty($name))
    {
      $view = null;
    }
    else
    {
      if (empty($module))
      {
        $module = SettingManager::GetSetting('DefaultModule');
      }
      $templatePath = $module . DIRECTORY_SEPARATOR . SettingManager::GetSetting('HooksPath')
        .  DIRECTORY_SEPARATOR . $name;
      $this ->view = new View();
      $this->view->SetTemplatePath($templatePath);
    }
  }
  
  /**
  * Возвращает содержимое "зацепки"
  * @return string
  */
  public abstract function __toString();
}