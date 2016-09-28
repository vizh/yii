<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo">
  <div class="container">
    <div class="row">
      <div class="side left span4">
        <img src="<?=$event->getLogo()->getNormal()?>" alt="" class="logo">
      </div>

      <div class="details span4 offset4">
        <h2 class="title"><?=$event->Title?></h2>
        <div class="type">
          <?=\Yii::t('app', 'Журнал')?>
        </div>
      </div>
    </div>

    <?if($this->eventPage):?>
    <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>