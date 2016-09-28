<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #ffffff;">
  <div class="container" style="background-image: url('/img/event/conversionconf13/header_bg.png'); background-position: right center; height: 246px; padding-top: 0; padding-bottom: 0; background-repeat: no-repeat;">
    <div class="row">
      <div class="side left span4" style="margin-top: 105px;">
        <img src="<?=$event->getLogo()->get150px()?>" alt="">
      </div>
    </div>
    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>