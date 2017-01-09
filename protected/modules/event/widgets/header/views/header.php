<?php
/**
 * @var $this \event\widgets\header\Header
 */
$event = $this->event;

// Вычислим компоненты из которых будет состоять строка адреса проведения мероприятия
if (null !== $address = $event->getContactAddress()) {
    $locationComponents = [];
    // Город проведения, если указан
    if ($address->City !== null)
        $locationComponents[] = sprintf('%s %s', Yii::t('app', 'г.'), $address->City->Name);
    // Место проведения, если указано
    if (!empty($address->Place))
        $locationComponents[] = $address->Place;
}

?>
<div class="b-event-promo <?=$event->Type->Code?> <?=$event->IdName?>">
  <div class="container">
    <div class="row">
      <div class="side left span2">
        <div class="logo img-circle">
          <img src="<?=$event->getLogo()->getNormal()?>" alt="<?=htmlspecialchars($event->Title)?>" />
        </div>
      </div>

      <div class="details span8 offset2">
        <h2 class="title"><?=$event->Title?></h2>
        <div class="type">
          <?=$event->Type->Title?>
        </div>
        <div class="duration">
          <span class="datetime">
            <span class="date">
              <?$this->widget('\event\widgets\Date', array('event' => $event))?>
            </span>
          </span>
        </div>
        <?if(isset($locationComponents)):?>
          <div class="location"><?=implode(', ', $locationComponents)?></div>
        <?endif?>
      </div>

      <?if($this->eventPage):?>
      <div class="side right span2">
        <div class="actions img-circle">
          <div class="calendar">
            <div class="calendar">
              <span><i class="icon-calendar"></i><br/><?=Yii::t('app', 'В календарь')?></span><br/>
              <a href="<?=Yii::app()->createUrl('/event/view/share', ['targetService' => 'Google', 'idName' => $event->IdName])?>" class="pseudo-link">Google Calendar</a>
              <a href="<?=Yii::app()->createUrl('/event/view/share', ['targetService' => 'iCal', 'idName' => $event->IdName])?>" class="pseudo-link">iCalendar (.ics)</a>
            </div>
          </div>
          <nav class="social">
            <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
            <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter"></div>
          </nav>
        </div>
      </div>
      <?endif?>
    </div>

    <?if($this->eventPage):?>
    <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
    <?endif?>
  </div>
</div>