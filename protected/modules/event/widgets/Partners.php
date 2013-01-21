<?php
namespace event\widgets;
class Partners extends \event\components\Widget
{

  public function run()
  {
    $this->render('partners', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Партнеры мероприятия');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
}

