<?php
namespace event\widgets;

class Comments extends \event\components\Widget
{

  public function run()
  {
    $this->render('comments', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Комментарии');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
}
