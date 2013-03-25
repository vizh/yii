<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #1074ac;">
  <div class="container" style="background-image: none;  height: 80px;">
    <div class="row">
      <div class="side left span4">
        <img src="/img/event/demo2013/logo.png" alt="DEMO Europe 2013" class="logo">
      </div>

      <?if ($this->eventPage):?>
        <div class="side right span8" style="text-align: right;">
          <img src="/img/event/demo2013/menu.png" class="logo">
        </div>
      <?endif;?>
    </div>

    <?if ($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
    </span>
    <?endif;?>
  </div>
</div>