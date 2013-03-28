<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #1074ac;">
  <div class="container" style="background-image: none;  height: 80px;">
    <img src="/img/event/demo2013/logo.png" alt="DEMO Europe 2013" class="logo">
    <?if ($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
    </span>
    <?endif;?>
  </div>
</div>