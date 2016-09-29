<?php
/**
 * @var $event \event\models\Event
 */
?>

<div class="datetime">
  <span class="date">
    <?if($event->StartMonth == $event->EndMonth):?>
      <?if(!empty($event->StartDay) && !empty($event->EndDay)):?>
        <span class="day"><?=$event->StartDay==$event->EndDay ? $event->StartDay : $event->StartDay . ' - ' . $event->EndDay?></span>
        <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?></span>
      <?else:?>
        <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?></span>
      <?endif?>

    <?else:?>
      <?if(!empty($event->StartDay)):?>
        <span class="day"><?=$event->StartDay?></span>
        <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?></span>
      <?else:?>
        <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?></span>
      <?endif?>
      -
      <?if(!empty($event->EndDay)):?>
        <span class="day"><?=$event->EndDay?></span>
        <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth)?></span>
      <?else:?>
        <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth, 'wide', true)?></span>
      <?endif?>
    <?endif?>

  </span>
</div>