<?php
/**
 * @var $event \event\models\Event
 */
if (empty($event->StartYear) || empty($event->EndYear) || empty($event->StartMonth) || empty($event->EndMonth))
{
  return;
}
?>
<?if($event->StartYear == $event->EndYear):?>
  <?if($event->StartMonth == $event->EndMonth):?>
    <?if(!empty($event->StartDay) && !empty($event->EndDay)):?>
      <?if($event->StartDay == $event->EndDay):?>
        <?=$event->StartDay?> <?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?> <?=$event->StartYear?>
      <?else:?>
        <?=$event->StartDay?>-<?=$event->EndDay?> <?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?> <?=$event->StartYear?>
      <?endif?>
    <?else:?>
      <?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?> <?=$event->StartYear?>
    <?endif?>
  <?else:?>
    <?if(!empty($event->StartDay) && !empty($event->EndDay)):?>
      <?=$event->StartDay?> <?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?>
      -
      <?=$event->EndDay?> <?=Yii::app()->getLocale()->getMonthName($event->EndMonth)?>
    <?else:?>
      <?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?>
      -
      <?=Yii::app()->getLocale()->getMonthName($event->EndMonth, 'wide', true)?>
    <?endif?>

    <?=$event->EndYear?>
  <?endif?>

<?else:?>
  <?if(!empty($event->StartDay)):?>
    <?=$event->StartDay?> <?=Yii::app()->getLocale()->getMonthName($event->StartMonth)?>
  <?else:?>
    <?=Yii::app()->getLocale()->getMonthName($event->StartMonth, 'wide', true)?>
  <?endif?>
  <?=$event->StartYear?>

  -

  <?if(!empty($event->EndDay)):?>
    <?=$event->EndDay?> <?=Yii::app()->getLocale()->getMonthName($event->EndMonth)?>
  <?else:?>
    <?=Yii::app()->getLocale()->getMonthName($event->EndMonth, 'wide', true)?>
  <?endif?>
  <?=$event->EndYear?>

<?endif?>