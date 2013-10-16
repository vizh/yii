<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #7b3384;">
  <div class="container" style="background-image: none;  height: 267px;">
    <div class="row">
      <div style=" background: url('/img/event/alm14/title.png') no-repeat scroll 0 0 rgba(0, 0, 0, 0);
      height: 202px;
      position: absolute;
      left: 0;
      top: 50px;
      width: 537px;"></div>

      <div style=" background: url('/img/event/alm14/b-raft.png') no-repeat scroll 0 0 rgba(0, 0, 0, 0);
      height: 391px;
      position: absolute;
      right: -142px;
      top: 16px;
      width: 712px;"></div>
    </div>
    <?if ($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>"><?=Yii::t('app', 'Все мероприятия');?></a>
    </span>
    <?endif;?>
  </div>
</div>