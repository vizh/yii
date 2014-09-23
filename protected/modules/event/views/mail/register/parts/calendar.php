<?
/**
 *  @var Event $event
 */
use event\models\Event;
?>
<img src="http://runet-id.com/images/mail/icons/google_calendar.png" />
<a href="<?=\Yii::app()->createAbsoluteUrl('/event/view/share', ['targetService' => 'Google', 'idName' => $event->IdName])?>" style="vertical-align: top;line-height: 15px;">Добавить в Google Calendar</a><br/>
<img src="http://runet-id.com/images/mail/ical.png" />
<a href="<?=\Yii::app()->createAbsoluteUrl('/event/view/share', ['targetService' => 'iCal', 'idName' => $event->IdName])?>"  style="vertical-align: top;line-height: 15px;">Добавить в iCalendar</a>