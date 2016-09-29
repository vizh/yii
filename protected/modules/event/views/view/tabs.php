<?php
/**
 * @var $event \event\models\Event
 */
$firstTab = true;
/** @var \event\models\WidgetClass[] $widgets */
$widgets = array();
foreach ($event->Widgets as $widget)
{
  if ($widget->getPosition() == \event\components\WidgetPosition::Tabs && $widget->getIsActive())
  {
    $widgets[] = $widget;
  }
}
?>

<div <?=sizeof($widgets) > 1 ? 'id="event-tabs"' : ''?> class="tabs">
  <?if(sizeof($widgets) > 1):?>
  <ul class="nav content-nav">
    <?foreach($widgets as $widget):?>
        <?if(!$firstTab):?>
        <li>/</li>
        <?endif?>
      <li><a href="#<?=$widget->getWidget()->getNameId()?>" class="pseudo-link"><?=$widget->getTitle()?></a></li>
      <?$firstTab = false?>
    <?endforeach?>
  </ul>
  <?endif?>

  <?foreach($widgets as $widget):?>
    <?$widget->run()?>
  <?endforeach?>
</div>

