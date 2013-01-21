<?php
namespace event\widgets;

class Registration extends \event\components\Widget
{

  public function run()
  {
    $this->render('registration', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Регистрация на мероприятии');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
}