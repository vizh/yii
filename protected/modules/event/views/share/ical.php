BEGIN:VCALENDAR<?="\r\n"?>
VERSION:2.0<?="\r\n"?>
PRODID:-//RUNET//NONSGML RUNET//RU<?="\r\n"?>
CALSCALE:GREGORIAN<?="\r\n"?>
METHOD:PUBLISH<?="\r\n"?>
BEGIN:VEVENT<?="\r\n"?>
DTSTART:<?=$event->StartYear?><?=$event->StartMonth?><?=$event->StartDay?>T090000<?="\r\n"?>
DTEND:<?=$event->EndYear?><?=$event->EndMonth?><?=$event->EndDay?>T180000<?="\r\n"?>
DESCRIPTION:<?=strip_tags($event->Info)?> <?=\Yii::t('app', 'Посмотрите полное описание мероприятия на')?> <?=$this->createAbsoluteUrl('/event/view/index', array('idName' => $event->IdName))?><?="\r\n"?>
SUMMARY: <?=$event->Title?><?="\r\n"?>
END:VEVENT<?="\r\n"?>
END:VCALENDAR<?="\r\n"?>
