<?php
/**
 * @var $this \event\widgets\header\PHDays
 */
$event = $this->event;
?>
<style>
  .b-event-promo .actions {
    background: none;
  }
  .b-event-promo, .b-event-promo a {
    color: #fff;
  }
  .b-event-promo .calendar a {
    border-bottom: 1px dotted #fff;
  }
  .b-event-promo .calendar {
    background: url("/img/event/telcloud14/ico_calendar.png") no-repeat;
    padding-left: 25px;
    width: auto !important;
    text-align: left;
  }
  .b-event-promo .social .b-share-icon {
    background: url("/img/event/telcloud14/icon-social-small.png") !important;
  }
  .b-event-promo .b-share__handle {
    height: 34px;
    padding: 0 !important;
  }
  .b-event-promo .b-share-icon {
    width: 34px;
    height: 34px;
  }
  .b-event-promo .social .b-share-icon_vkontakte,
  .b-event-promo .social .b-share-icon_vkontakte:hover{
    background-position: 34px 0 !important;
  }
  .b-event-promo .social .b-share-icon_facebook,
  .b-event-promo .social .b-share-icon_facebook:hover{
    background-position: 103px 0 !important;
  }
  .b-event-promo .social .b-share-icon_twitter,
  .b-event-promo .social .b-share-icon_twitter:hover{
    background-position: 69px 0 !important;
  }
</style>
<div class="b-event-promo" style="background: url('/img/event/telcloud14/header-bg-fill.jpg') repeat-x center center #137aaa; height: 300px;">
  <div class="container" style="background: none;">
    <div class="row">
      <div class="side left span2">
        <a href="/event/telcloud14/"><img src="/img/event/telcloud14/logo.png" alt="<?=CHtml::encode($event->Title);?>" style="margin-top: 10px;"></a>
      </div>

      <div class="details span8 offset2" style="background: url('/img/event/telcloud14/header-bg.png') no-repeat center center; height: 173px;">

      </div>

      <?if ($this->eventPage):?>
        <div class="side right span2">
          <div class="actions">
            <div class="calendar">
              <div>
                <span>В календарь</span><br/>
                <a href="<?=\Yii::app()->createUrl('/event/view/share', ['targetService' => 'Google', 'idName' => $event->IdName])?>" class="pseudo-link">Google Calendar</a><br/>
                <a href="<?=\Yii::app()->createUrl('/event/view/share', ['targetService' => 'iCal', 'idName' => $event->IdName])?>" class="pseudo-link">iCalendar (.ics)</a>
              </div>
            </div>
            <nav class="social">
              <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
              <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter"></div>
            </nav>
          </div>
        </div>
      <?endif;?>
    </div>
  </div>
</div>