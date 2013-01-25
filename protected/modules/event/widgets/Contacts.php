<?php
namespace event\widgets;

class Contacts extends \event\components\Widget 
{
  public function run()
  {
    $phones = array();
    foreach ($this->event->LinkPhones as $linkPhone)
    {
      $phones[] = $linkPhone->Phone->__toString();
    }
    $this->render('contacts', array('phones' => $phones));
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