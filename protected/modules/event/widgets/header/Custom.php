<?php
namespace event\widgets\header;

class Custom extends \event\widgets\Header
{
  public function run()
  {
    $this->render('custom/'.$this->event->IdName, array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Кастомизированная шапка мероприятия');
  }
}
