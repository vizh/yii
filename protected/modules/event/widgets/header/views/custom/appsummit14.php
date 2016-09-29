<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
$height = $this->eventPage ? 225 : 180;
?>

<style type="text/css">
  .appsummit14-topPicture-register{
    background: none repeat scroll 0 0 #0D90EB;
    border: 1px solid #0D90EB;
    color: #ffffff;
    cursor: pointer;
    display: inline-block;
    font: 24px/30px 'Segoe UI', Roboto;
    padding: 23px 0 26px;
    transition: background 0.3s ease 0s;
    margin: 0 auto;
    width: 350px;
    text-align: center;
    text-decoration: none;
  }
  .appsummit14-topPicture-register:hover{
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #0D90EB;
    color: #0D90EB;
    text-decoration: none;
  }
  .appsummit14-title{
    background: url('/img/event/appsummit14/title.png') no-repeat scroll 0 0 transparent;
    height: 53px;
    width: 499px;
    margin: 0 auto;
    display: block;
  }
  .appsummit14-detail{
    font-weight: 300;
    font-size: 20px;
    line-height: 30px;
    text-align: center;
    margin-top: 100px;
    margin-bottom: 10px;
  }
</style>

<div class="b-event-promo" style="background: #ffffff;">
  <div class="container" style="background-image: none;  height: <?=$height?>px;">
    <div class="row">
      <div class="span12">
        <a target="_blank" href="http://events.techdays.ru/AppSummit/2014-03/" class="appsummit14-title"></a>
        <div class="appsummit14-detail">25 марта, Москва, Digital October</div>
        <?if($this->eventPage):?>
        <a target="_blank" href="http://events.techdays.ru/AppSummit/2014-03/registration" class="appsummit14-topPicture-register">зарегистрироваться</a>
        <?endif?>
      </div>
    </div>
  </div>
</div>