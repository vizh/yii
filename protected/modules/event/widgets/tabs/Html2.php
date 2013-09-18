<?php
namespace event\widgets\tabs;

class Html extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['TabTitle2', 'TabContent2'];
  }

  public function run()
  {
    echo $this->TabContent2;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->TabTitle2;
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}