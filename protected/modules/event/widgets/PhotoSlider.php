<?php
namespace event\widgets;

class PhotoSlider extends \event\components\Widget
{

  public function init()
  {
    \Yii::app()->clientScript->registerPackage('runetid.jquery.ioslider');
  }

  public function run()
  {
    $this->render('photoslider', array());
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Слайдер фотографий');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Sidebar;
  }
}
