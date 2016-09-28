<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #ffffff;">
  <div class="container" style="background-image: none;  height: 300px; padding-top: 20px; padding-bottom: 25px;">
    <div class="row">
      <div class="span12">
        <img src="/img/event/telekom13/banner_940_300.jpg" alt="<?=CHtml::encode($event->Title)?>" >
      </div>
    </div>
    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>