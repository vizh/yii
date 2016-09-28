<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #0194a6 url('/img/event/forumspb13/right.jpg') no-repeat right center;">
  <div style="background: url('/img/event/forumspb13/left.jpg') no-repeat; height: 260px; width: 440px; left: 0; position: absolute;"></div>
  <div class="container" style="background-image: url('/img/event/forumspb13/bg.jpg'); background-repeat: no-repeat; background-position: center; height: 260px; padding: 0;">
    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>