<?php
namespace event\widgets;
class Adv extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Sidebar;
  public function widgetName()
  {
    return \Yii::t('app', 'Рекламный баннер');
  }
  
  public function run()
  {
    $this->render('adv', array());
  }
}

?>
