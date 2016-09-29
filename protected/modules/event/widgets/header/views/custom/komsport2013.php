<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background: #ffffff;">
  <div class="container" style="background-image: none;  height: 300px; padding-top: 20px; padding-bottom: 25px;">
    <div class="row">
      <div class="span12">
        <img src="/img/event/komsport2013/banner.jpg" alt="<?=CHtml::encode($event->Title)?>" >

        <nav class="social" style="position: relative; top: -290px; left: -60px;">
          <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
          <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter"></div>
        </nav>
      </div>
    </div>
    <?if($this->eventPage):?>
      <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>