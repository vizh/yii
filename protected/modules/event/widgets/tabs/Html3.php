<?php
namespace event\widgets\tabs;

class Html extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['TabTitle3', 'TabContent3'];
  }

  public function run()
  {
    echo $this->TabContent3;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->TabTitle3;
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}