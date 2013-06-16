<?php

/** @var $event \event\models\Event */
/** @var $dateStart String */
/** @var $dateEnd String */

?>
BEGIN:VCALENDAR<?="\r"?>
VERSION:2.0<?="\r"?>
X-WR-TIMEZONE:Europe/Moscow<?="\r"?>
PRODID:-//RUNET//NONSGML RUNET//RU<?="\r"?>
CALSCALE:GREGORIAN<?="\r"?>
METHOD:PUBLISH<?="\r"?>
BEGIN:VEVENT<?="\r"?>
DTSTART:<?=$dateStart?><?="\r"?>
DTEND:<?=$dateEnd?>T180000<?="\r"?>
DESCRIPTION:<?=strip_tags($event->Info)?><?="\r"?>
URL:<?=$this->createAbsoluteUrl('/event/view/index', array('idName' => $event->IdName))?><?="\r"?>
SUMMARY:<?=$event->Title?><?="\r"?>
END:VEVENT<?="\r"?>
END:VCALENDAR<?="\r"?>
