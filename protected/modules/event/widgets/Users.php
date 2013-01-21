<?php
namespace event\widgets;

class Users extends \event\components\Widget
{

  public function run()
  {
    $this->render('users', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Список участников');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}
