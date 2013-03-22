<?php
namespace event\widgets\header;

class PhDays extends \event\components\Widget
{
  public function run()
  {
    $this->render('phdays', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Шапка мероприятия PhDays');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Header;
  }
}