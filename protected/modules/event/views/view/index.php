<?php foreach ($event->Widgets as $widget):?>
  <?php if ($widget->getWidget()->position == \event\components\WidgetPosition::Header):?>
    <?php $widget->getWidget()->run();?>
  <?php endif;?>
<?php endforeach;?>

<div class="event-page">
  <div class="container">
    <div class="row">
      <aside class="sidebar span3 pull-left">
        <?php foreach ($event->Widgets as $widget):?>
          <?php if ($widget->getWidget()->position == \event\components\WidgetPosition::Sidebar):?>
            <?php $widget->getWidget()->run();?>
          <?php endif;?>
        <?php endforeach;?>
      </aside>

      <div class="span8 pull-right">
        <?php foreach ($event->Widgets as $widget):?>
          <?php if ($widget->getWidget()->position == \event\components\WidgetPosition::Content):?>
            <?php $widget->getWidget()->run();?>
          <?php endif;?>
        <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
