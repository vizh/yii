<?php
/**
 * @var $event \event\models\Event
 */
$firstTab = true;
?>

<div id="event-tabs" class="tabs">
  <ul class="nav">
    <?foreach ($event->Widgets as $widget):?>
      <?if ($widget->getPosition() == \event\components\WidgetPosition::Tabs):?>
        <?if (!$firstTab):?>
        <li>/</li>
        <?endif;?>
      <li><a href="#<?=$widget->getWidget()->getNameId();?>" class="pseudo-link"><?=$widget->getTitle();?></a></li>
      <?$firstTab = false;?>
      <?endif;?>
    <?endforeach;?>
  </ul>

  <?foreach ($event->Widgets as $widget):?>
  <?if ($widget->getPosition() == \event\components\WidgetPosition::Tabs):?>
    <?$widget->run();?>
    <?endif;?>
  <?endforeach;?>
</div>

