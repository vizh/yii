<?php
namespace event\widgets\tabs;

class Html extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['TabTitle', 'TabContent'];
  }

  public function run()
  {
    echo $this->TabContent;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->TabTitle;
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}