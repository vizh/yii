<?php
namespace event\widgets;
class Contacts extends \event\components\Widget 
{
  public $position = \event\components\WidgetPosition::Sidebar;
  
  public function widgetName()
  {
    return \Yii::t('app', 'Контактная информация');
  }
  
  public function run()
  {
    $this->render('contacts', array());
  }
}
