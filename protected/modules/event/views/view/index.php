<?php
/**
 * @var $event \event\models\Event
 * @var $this ViewController
 */
$renderTabs = true;

foreach($event->Widgets as $widget)
  if($widget->getPosition() == \event\components\WidgetPosition::Header)
    $widget->run();

$fullWidth = false;
foreach($event->Widgets as $widget)
{
  if($widget->getPosition() == \event\components\WidgetPosition::FullWidth)
  {
    $widget->run();
    $fullWidth = true;
  }
}
if ($fullWidth)
  return;

?>

<div class="event-page <?=$event->FullWidth ? 'event-page-fullwidth' : '';?>">
  <div class="container">
    <div class="row">

      <?if (!$event->FullWidth):?>
        <aside class="sidebar span3 pull-left">
          <?foreach ($event->Widgets as $widget):?>
            <?if ($widget->getPosition() == \event\components\WidgetPosition::Sidebar && $widget->getIsActive()):?>
              <?$widget->run()?>
            <?endif?>
          <?endforeach?>
        </aside>
        <div class="span8 pull-right">
          <?foreach($event->Widgets as $widget):?>
            <?if($widget->getPosition() == \event\components\WidgetPosition::Content):?>
              <?$widget->run()?>
            <?elseif($renderTabs && $widget->getPosition() == \event\components\WidgetPosition::Tabs):?>
              <?$this->renderPartial('tabs', array('event' => $event))?>
              <?$renderTabs = false?>
            <?endif?>
          <?endforeach?>
        </div>
      <?else:?>
        <?foreach($event->Widgets as $widget):?>
          <?if($widget->getPosition() != \event\components\WidgetPosition::Tabs && $widget->getPosition() != \event\components\WidgetPosition::Header):?>
            <?$widget->run();?>
          <?elseif($renderTabs && $widget->getPosition() == \event\components\WidgetPosition::Tabs):?>
            <?$this->renderPartial('tabs', array('event' => $event))?>
            <?$renderTabs = false?>
          <?endif?>
        <?endforeach?>
      <?endif;?>
    </div>
  </div>
</div>
