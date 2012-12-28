<?php
namespace event\widgets;
class Partners extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Content;
  
  public function widgetName()
  {
    return \Yii::t('app', 'Партнеры мероприятия');
  }
  
  public function run()
  {
    $this->render('partners', array());
  }
}

?>
