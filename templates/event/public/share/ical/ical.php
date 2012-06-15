BEGIN:VCALENDAR<?="\r\n";?>
VERSION:2.0<?="\r\n";?>
PRODID:-//rocID//NONSGML rocID//RU<?="\r\n";?>
CALSCALE:GREGORIAN<?="\r\n";?>
METHOD:PUBLISH<?="\r\n";?>
BEGIN:VEVENT<?="\r\n";?>
DTSTART:<?=$this->DateStart;?>T090000<?="\r\n";?>
DTEND:<?=$this->DateEnd;?>T180000<?="\r\n";?>
DESCRIPTION: <?=$this->Info;?> Посмотрите полное описание мероприятия на http://<?=$this->SiteHost;?>/events/<?=$this->IdName;?>/<?="\r\n";?>
SUMMARY: <?=$this->Name;?><?="\r\n";?>
END:VEVENT<?="\r\n";?>
END:VCALENDAR<?="\r\n";?>