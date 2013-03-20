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
        <img src="<?=$event->getLogo()->getNormal();?>" alt="" class="logo">
      </div>

      <div class="details span4 offset4">
        <h2 class="title"><?=$event->Title;?></h2>
        <div class="type">
          <img src="/images/blank.gif" alt="" class="i-event_small <?=$event->Type->CssClass;?>"><?=$event->Type->Title;?>
        </div>
        <div class="duration">
          <span class="datetime">
            <span class="date">
              <?$this->widget('\event\widgets\Date', array('event' => $event));?>
            </span>
          </span>
        </div>
        <?if ($event->getContactAddress() != null && !empty($event->getContactAddress()->Place)):?>
          <div class="location"><?=$event->getContactAddress()->Place;?></div>
        <?endif;?>
      </div>

      <?if ($this->eventPage):?>
      <div class="side right span4">
        <div class="actions">
          <div class="calendar img-circle">
            <a href="<?='webcal://'.RUNETID_HOST.\Yii::app()->getController()->createUrl('/event/share/ical', array('idName' => $event->IdName));?>" class="pseudo-link">
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
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
    </span>
    <?endif;?>
  </div>
</div>