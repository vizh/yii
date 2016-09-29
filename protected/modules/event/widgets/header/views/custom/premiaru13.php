<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>
<div class="b-event-promo" style="background-image: url('/img/event/premiaru13/bg.jpg'); background-repeat: repeat-x;">
  <div class="container" style="background: url('/img/event/premiaru13/banner.png') no-repeat center 11px; height: 184px;">
    <div class="row">
      <div class="span12">
      </div>
    </div>
    <?if($this->eventPage):?>
      <span class="all" style="bottom: -30px;">
        <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
      </span>
    <?endif?>
  </div>
</div>