<?php
namespace event\widgets;
use event\components\Widget;

/**
 * @property string $ProgramHead
 * @property string $ProgramText
 */
class Program extends Widget
{

  /**
   * @return \string[]
   */
  public function getAttributeNames()
  {
    return array('ProgramHead', 'ProgramText');
  }


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