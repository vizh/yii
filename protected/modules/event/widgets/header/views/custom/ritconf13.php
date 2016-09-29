<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #ffffff;">
  <div class="container" style="padding-top: 0; padding-bottom: 10px; background: none;">
    <div class="row">
      <div class="span12">
        <a target="_blank" href="http://ritconf.ru/"><img src="/img/event/ritconf13/header.jpg" alt="<?=$event->Title?>" title="<?=$event->Title?>"></a>
      </div>
    </div>

    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>