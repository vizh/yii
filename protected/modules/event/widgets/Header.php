<?php
namespace event\widgets;

class Header extends \event\components\Widget
{
  public function run()
  {
    $this->render('header', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Шапка мероприятия');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Header;
  }
}
