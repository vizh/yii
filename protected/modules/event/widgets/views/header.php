<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>
<div class="b-event-promo <?=$event->Type->Code;?>">
  <div class="container">
    <div class="row">
      <div class="side left span2">
        <div class="logo img-circle">
          <img src="<?=$event->getLogo()->getNormal();?>" alt="<?=$event->Title;?>" />
        </div>
      </div>

      <div class="details span8 offset2">
        <h2 class="title"><?=$event->Title;?></h2>
        <div class="type">
          <?=$event->Type->Title;?>
        </div>
        <div class="duration">
          <span class="datetime">
            <span class="date">
              <?$this->widget('\event\widgets\Date', array('event' => $event));?>
            </span>
          </span>
        </div>
        <?if ($event->getContactAddress() != null && !empty($event->getContactAddress()->Place)):?>
          <div class="location">
            <?=$event->getContactAddress()->Place;?></div>
        <?endif;?>
      </div>

      <?if ($this->eventPage):?>
      <div class="side right span2">
        <div class="actions img-circle">
          <div class="calendar">
            <a href="<?=\Yii::app()->createUrl('/event/view/share', ['targetService' => 'iCal', 'idName' => $event->IdName])?>" class="pseudo-link">
              <i class="icon-calendar"></i><br><?=\Yii::t('app', 'Добавить в&nbsp;календарь');?>
            </a>
          </div>
          <nav class="social">
            <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
            <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter"></div>
          </nav>
        </div>
      </div>
      <?endif;?>
    </div>

    <?if ($this->eventPage):?>
    <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>"><?=Yii::t('app', 'Все мероприятия');?></a>
    </span>
    <?endif;?>
  </div>
</div>