<?php
namespace event\widgets\tabs;

class Html6 extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['TabTitle6', 'TabContent6'];
  }

  public function run()
  {
    $this->render('html', ['TabContent' => $this->TabContent6]);
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->TabTitle6;
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }
}