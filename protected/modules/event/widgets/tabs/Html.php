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
    $this->render('html', ['TabContent' => $this->TabContent]);
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