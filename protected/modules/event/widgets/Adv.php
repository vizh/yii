<?php
namespace event\widgets;
class Adv extends \event\components\Widget
{
  public function run()
  {
    $this->render('adv', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Рекламный баннер');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Sidebar;
  }
}