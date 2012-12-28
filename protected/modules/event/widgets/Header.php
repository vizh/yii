<?php
namespace event\widgets;
class Header extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Header;
  public function widgetName()
  {
    return \Yii::t('app', 'Шапка мероприятия');
  }
  
  public function run()
  {
    $this->render('header', array());
  }
}

?>
