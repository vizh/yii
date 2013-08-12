<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>
<div class="b-event-promo <?=$event->IdName;?>">
  <div class="container">
    <div class="row">
      <div class="span12">
        <nav class="social" style="position: relative; display: none;">
          <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
          <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter"></div>
        </nav>
      </div>
    </div>
    <?if ($this->eventPage):?>
      <span class="all">
        <a href="<?=Yii::app()->createUrl('/event/list/index');?>"><?=Yii::t('app', 'Все мероприятия');?></a>
      </span>
    <?endif;?>
  </div>
</div>