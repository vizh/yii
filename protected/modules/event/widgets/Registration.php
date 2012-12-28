<?php
namespace event\widgets;
class Registration extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Content;
    
  public function widgetName()
  {
    return \Yii::t('app', 'Регистрация на мероприятии');
  }
  
  public function run()
  {
    $this->render('registration', array());
  }
}