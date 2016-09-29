<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<style type="text/css">
  .alm14-topPicture-register{
    background: none repeat scroll 0 0 #5E1866;
    color: #ffffff;
    cursor: pointer;
    display: inline-block;
    font: 28px/30px 'Segoe UI',Arial;
    height: 53px;
    letter-spacing: -0.01em;
    padding: 17px 24px 0;
    transition: background-color 0.5s ease 0s, color 0.5s ease 0s;
    position: absolute;
    left: 0;
    bottom: 70px;
  }
  .alm14-topPicture-register:hover{
    background-color: #3f1044;
  }
  .alm14-title{
    background: url('/img/event/alm14/title.png') no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 202px;
    position: absolute;
    left: -5px;
    top: 50px;
    width: 537px;
  }
  .alm14-raft{
    background: url('/img/event/alm14/b-raft.png') no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 391px;
    position: absolute;
    right: -142px;
    top: 16px;
    width: 712px;
  }
</style>

<div class="b-event-promo" style="background: #7b3384;">
  <div class="container" style="background-image: none;  height: 267px;">
    <div class="row">
      <div class="span12">
        <div class="alm14-title"></div>
        <a target="_blank" href="http://events.techdays.ru/ALM-Summit/2014-02/registration"><div class="alm14-topPicture-register">зарегистрироваться</div></a>
        <div class="alm14-raft"></div>
      </div>

    </div>
    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>