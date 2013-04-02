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
    $widgets = array();
    $files = scandir(\Yii::getPathOfAlias('event.widgets'));
    foreach ($files as $file)
    {
      if (($pos = strrpos($file, '.php')) !== false)
      {
        $file = substr($file, 0, $pos);
        $widget = \Yii::app()->getController()->createWidget('\event\widgets\\'.$file, array('event' => $event));
        if ($widget instanceof \event\components\IWidget)
        {
          $widgets[] = $widget;
        }
      }
    }
    return $widgets;
  }
}
