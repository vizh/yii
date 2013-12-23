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
    $classes = \event\models\WidgetClass::model()->byVisible(true)->findAll();

    $widgets = [];
    foreach ($classes as $class)
    {
      $widget = \Yii::app()->getController()->createWidget($class->Class, array('event' => $event));
      if ($widget instanceof \event\components\IWidget)
      {
        $widgets[] = $widget;
      }
    }
    return $widgets;
  }
}
