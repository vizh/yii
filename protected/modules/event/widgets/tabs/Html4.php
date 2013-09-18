<?php
namespace event\widgets\tabs;

class Html4 extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['TabTitle4', 'TabContent4'];
  }

  public function run()
  {
    $this->render('html', ['TabContent' => $this->TabContent4]);
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->TabTitle4;
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}