<?php
/** @var $user User */
$user = $this->User;
/** @var $event Event */
$event = $this->Event;
?>
Сегодня, <?=date('Y-m-d');?> в <?=date('H:i');?> на [<?=$event->Name;?>] был изменен статус участника.

ROCID: <?=$user->RocId;?>

ФИО: <?=$user->GetFullName();?>


Старый статус: <?=$this->OldRole->Name;?>

Новый статус: <?=$this->NewRole->Name;?>


--
Письмо отправлено автоматически
www.rocid.ru