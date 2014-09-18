<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<style type="text/css">
    .appday14-topPicture-register{
        cursor: pointer;
        font: 1.75em 'Segoe UI Light', 'Segoe UI', Arial, Verdana, sans-serif;
        letter-spacing: 0.02em;
        color: #fff;
        text-align: center;
        text-shadow: 1px 1.732px 0px rgba(0, 2, 4, 0.1);
        position: absolute;
        width: 15.778em;
        left: 50%;
        top: 150px;
        margin-left: -7.889em;
        padding: 0.722em 0 0.778em;
        z-index: 10;
        background-image: -moz-linear-gradient( 90deg, rgb(0,153,204) 0%, rgb(14,135,175) 100%);
        background-image: -webkit-linear-gradient( 90deg, rgb(0,153,204) 0%, rgb(14,135,175) 100%);
        background-image: -ms-linear-gradient( 90deg, rgb(0,153,204) 0%, rgb(14,135,175) 100%);
        box-shadow: inset 1.5px 2.598px 2px 0px rgba(255, 255, 255, 0.004);
    }
    .appday14-topPicture-register:hover{
        background-image: -moz-linear-gradient( 90deg, rgb(0,153,204) 0%, rgb(19,117,150) 100%);
        background-image: -webkit-linear-gradient( 90deg, rgb(0,153,204) 0%, rgb(19,117,150) 100%);
        background-image: -ms-linear-gradient( 90deg, rgb(0,153,204) 0%, rgb(19,117,150) 100%);
    }
</style>

<div class="b-event-promo" style="background: url('/img/event/2014/appday14-header.jpg') no-repeat scroll center 0 transparent;">
    <div class="container" style="background-image: none;  height: 153px;">
        <div class="row">
            <div class="span12">
                <a target="_blank" href="http://events.techdays.ru/AppDay/2014-11/"><div class="appday14-topPicture-register">зарегистрироваться</div></a>
            </div>
        </div>
        <?if ($this->eventPage):?>
            <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>"><?=Yii::t('app', 'Все мероприятия');?></a>
    </span>
        <?endif;?>
    </div>
</div>