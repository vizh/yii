<?php
namespace event\widgets;

class Program extends \event\components\Widget
{

  public function run()
  {
    $this->render('program', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Программа мероприятия');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}
