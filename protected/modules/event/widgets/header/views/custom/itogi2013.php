<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="height: 250px; background: url('/img/event/itogi2013/bg.jpg?20131128') no-repeat scroll center 0 #ffffff;">
  <div class="container" style="background-image: none; height: 125px;">
    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>

  </div>

</div>