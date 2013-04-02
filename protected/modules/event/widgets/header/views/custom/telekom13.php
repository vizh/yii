<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #ffffff;">
  <div class="container" style="background-image: none;  height: 300px; padding-top: 0;">
    <div class="row">
      <div class="span12">
        <img src="/img/event/telekom13/banner_940_300.jpg" alt="" class="logo">
      </div>
    </div>
    <?if ($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
    </span>
    <?endif;?>
  </div>
</div>