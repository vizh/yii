<?php
namespace event\widgets;
class About extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Content;
  
  public function widgetName()
  {
    return \Yii::t('app', 'Описание, программа, участники мероприятия');
  }
  
  public function run()
  {
    $this->render('about', array());
  }
}
