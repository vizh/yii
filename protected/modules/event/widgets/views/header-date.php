<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
if (empty($event->StartYear) || empty($event->EndYear) || empty($event->StartMonth) || empty($event->EndMonth))
{
  return;
}
?>

<?if ($event->StartYear == $event->EndYear):?>
  <?if ($event->StartMonth == $event->EndMonth):?>
  <?else:?>
  <?endif;?>
<?else:?>
  <?if (!empty($event->StartDay)):?>
  <span class="day"><?=$event->StartDay;?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth);?></span>
  <?else:?>
  <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true);?></span>
  <?endif;?>
  <span class="year"><?=$event->StartYear;?></span>

  <span class="day">-</span>

  <?if (!empty($event->EndDay)):?>
  <span class="day"><?=$event->EndDay;?></span> <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth);?></span>
  <?else:?>
  <span class="month"><?=Yii::app()->getLocale()->getMonthName($event->EndMonth, 'wide', true);?></span>
  <?endif;?>
  <span class="year"><?=$event->EndYear;?></span>
<?endif;?>
<span class="day">17-19</span> <span class="month">октября</span> <span class="year">2012</span>
