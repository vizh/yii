<?php
/**
 * @var $event \event\models\Event
 * @var $this ViewController
 */
$renderTabs = true;
?>
<?foreach ($event->Widgets as $widget):?>
  <?if ($widget->getPosition() == \event\components\WidgetPosition::Header):?>
    <?$widget->run();?>
  <?endif;?>
<?endforeach;?>

<div class="event-page">
  <div class="container">
    <div class="row">
      <aside class="sidebar span3 pull-left">
        <?foreach ($event->Widgets as $widget):?>
          <?if ($widget->getPosition() == \event\components\WidgetPosition::Sidebar):?>
            <?$widget->run();?>
          <?endif;?>
        <?endforeach;?>
      </aside>

      <div class="span8 pull-right">
        <?foreach ($event->Widgets as $widget):?>
          <?if ($widget->getPosition() == \event\components\WidgetPosition::Content):?>
            <?$widget->run();?>
          <?elseif ($renderTabs && $widget->getPosition() == \event\components\WidgetPosition::Tabs):?>
            <?$this->renderPartial('tabs', array('event' => $event));?>
            <?$renderTabs = false;?>
          <?endif;?>
        <?endforeach;?>
      </div>
    </div>
  </div>
</div>
