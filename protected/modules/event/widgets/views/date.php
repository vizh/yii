<?php
if (empty($event->StartYear) || empty($event->EndYear) || empty($event->StartMonth) || empty($event->EndMonth))
{
  return;
}
?>

<?if($event->StartYear == $event->EndYear):?>
  <?if($event->StartMonth == $event->EndMonth):?>
    <?if(!empty($event->StartDay) && !empty($event->EndDay)):?>
      <?if($event->StartDay == $event->EndDay):?>
      <span class="day"><?=$event->StartDay?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?></span> <span class="year"><?=$event->StartYear?></span>
      <?else:?>
      <span class="day"><?=$event->StartDay?>-<?=$event->EndDay?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?></span> <span class="year"><?=$event->StartYear?></span>
      <?endif?>
    <?else:?>
    <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?></span> <span class="year"><?=$event->StartYear?></span>
    <?endif?>
  <?else:?>
    <?if(!empty($event->StartDay) && !empty($event->EndDay)):?>
    <span class="day"><?=$event->StartDay?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?></span>
    <span class="day">-</span>
    <span class="day"><?=$event->EndDay?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth)?></span>
    <?else:?>
    <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?></span>
    <span class="month">-</span>
    <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth, 'wide', true)?></span>
  <?endif?>
  <span class="year"><?=$event->EndYear?></span>
<?endif?>

<?else:?>
  <?if(!empty($event->StartDay)):?>
  <span class="day"><?=$event->StartDay?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?></span>
  <?else:?>
  <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?></span>
  <?endif?>
  <span class="year"><?=$event->StartYear?></span>

  <span class="day">-</span>

  <?if(!empty($event->EndDay)):?>
  <span class="day"><?=$event->EndDay?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth)?></span>
  <?else:?>
  <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth, 'wide', true)?></span>
  <?endif?>
  <span class="year"><?=$event->EndYear?></span>
<?endif?>