<?php
namespace event\widgets;
class PhotoSlider extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Sidebar;
  
  public function widgetName()
  {
    return \Yii::t('app', 'Слайдер фотографий');
  }
  
  public function init()
  {
    \Yii::app()->clientScript->registerPackage('runetid.jquery.ioslider');
  }

  public function run()
  {
    $this->render('photoslider', array());
  }
}
