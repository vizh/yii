<?php
namespace event\widgets;

class Contacts extends \event\components\Widget 
{
  public function run()
  {
    $this->render('contacts', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Контактная информация');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Sidebar;
  }
}