<?php
namespace event\widgets;
class About extends \event\components\Widget
{

  public function run()
  {
    $this->render('about', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Полное описание');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}
