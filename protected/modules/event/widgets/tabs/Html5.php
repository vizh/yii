<?php
namespace event\widgets\tabs;

class Html extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['TabTitle5', 'TabContent5'];
  }

  public function run()
  {
    echo $this->TabContent5;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->TabTitle5;
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}