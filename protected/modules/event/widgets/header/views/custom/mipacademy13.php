<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #4f2d63;">
  <div class="container" style="background: #39174d; width: 1000px;  height: 150px;">
    <div class="row">
      <div class="span12" style="width: 985px; padding-left: 30px;">
        <a href="http://mipacademy.ru/" target="_blank">
          <img src="/img/event/mipacademy13/header.png" alt="<?=CHtml::encode($event->Title)?>">
        </a>
      </div>
    </div>
    <?if($this->eventPage):?>
      <span class="all"><a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a></span>
    <?endif?>
  </div>
</div>