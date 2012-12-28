<?php
namespace event\widgets;
class Location extends \event\components\Widget 
{
  public $position = \event\components\WidgetPosition::Sidebar;
  
  public function widgetName()
  {
    return \Yii::t('app', 'Место проведения мероприятия на карте');
  }
  
  public function run()
  {
    $this->render('location', array());
  }
}
