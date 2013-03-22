<?php
/**
 * @var $this \event\widgets\header\PHDays
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: url('/img/event/phdays/n62.jpg') repeat scroll 0 0 transparent;">
  <div class="container" style="padding-top: 0; background: url('/img/event/phdays/wrap_bg13.jpg') no-repeat scroll 50% 0 #c4c4c4; width: 1018px">
    <div class="row">
      <div class="span12" style="width: 1018px;">
        <img src="/img/event/phdays/top_bg2.jpg" alt="<?=$event->Title;?>" title="<?=$event->Title;?>">
      </div>
    </div>

    <?if ($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
    </span>
    <?endif;?>
  </div>
</div>