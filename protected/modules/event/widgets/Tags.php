<?php
namespace event\widgets;
class Tags extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Sidebar;
  
  public function widgetName()
  {
    return \Yii::t('app', 'Теги мероприятия');
  }
  
  public function run()
  {
    $this->render('tags', array());
  }
}

?>
