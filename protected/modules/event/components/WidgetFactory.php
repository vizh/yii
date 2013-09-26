<?php
namespace event\components;
class WidgetFactory
{
  /**
   * Возвращает список всех виджетов
   * @param \event\models\Event $event
   * @return \event\components\Widget[]
   */
  public function getWidgets($event)
  {
    $clases = [
      '\event\widgets\About',
      '\event\widgets\Adv',
      '\event\widgets\Comments',
      '\event\widgets\Contacts',
      '\event\widgets\Date',
      '\event\widgets\FastRegistration',
      '\event\widgets\Header',
      '\event\widgets\Invite',
      '\event\widgets\Location',
      '\event\widgets\Partners',
      '\event\widgets\PhotoSlider',
      '\event\widgets\ProfessionalInterests',
      '\event\widgets\Program',
      '\event\widgets\Registration',
      '\event\widgets\Users',
      '\event\widgets\header\Banner',
      '\event\widgets\header\Custom'
    ];
    
    $widgets = [];
    foreach ($clases as $class)
    {
      $widget = \Yii::app()->getController()->createWidget($class, array('event' => $event));
      if ($widget instanceof \event\components\IWidget)
      {
        $widgets[] = $widget;
      }
    }
    return $widgets;
  }
}
