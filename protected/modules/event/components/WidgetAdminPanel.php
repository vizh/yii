<?php
namespace event\components;
abstract class WidgetAdminPanel implements IWidgetAdminPanel
{
  protected $widget;
  public function __construct($widget)
  {
    $this->widget = $widget;
  }
  
  abstract function __toString();

  public function getEvent()
  {
    return $this->widget->getEvent();
  }
  
  private $errors = [];
  public function addError($message)
  {
    if ($message instanceof \CFormModel)
    {
      foreach ($message->getErrors() as $errors)
      {
        foreach ($errors as $message)
        {
          $this->addError($message);
        }
      }
    }
    else
    {
      $this->errors[] = $message;
    }
  }
  
  protected function render($params = [])
  {
    $class = get_class($this);
    $class = substr($class, mb_strrpos($class, '\\')+1, mb_strlen($class));
    $view  = 'event.widgets.panels.views.'.mb_strtolower($class);
    $params = array_merge($params, ['widget' => $this]);
    return \Yii::app()->getController()->renderPartial($view, $params, true);
  }
  
  /**
   * 
   * @param string $header
   * @param string $footer
   * @return string
   */
  public function errorSummary($header = '', $footer = '')
  {
    if (empty($this->errors)) return '';
    
    $result = $header.'<div class="errorSummary"><ul>';
    foreach ($this->errors as $error)
      $result .= '<li>'.$error.'</li>';
    
    $result .= '</ul></div>'.$footer;
    return $result;
  }
  
  const FLASH_SUCCESS_KEY = 'wap.success';
  public function setSuccess($message)
  {
    \Yii::app()->getUser()->setFlash(self::FLASH_SUCCESS_KEY, $message);
  }
  
  public function getSuccess()
  {
    return \Yii::app()->getUser()->getFlash(self::FLASH_SUCCESS_KEY);
  }
  
  public function hasSuccess()
  {
    return \Yii::app()->getUser()->hasFlash(self::FLASH_SUCCESS_KEY);
  }
}
