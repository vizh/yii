<?php
/** @var $user User */
$user = $this->User;
/** @var $event Event */
$event = $this->Event;

$employment = $user->GetPrimaryEmployment();
$email = $user->GetEmail();
$phones = $user->GetPhones();
?>
Сегодня, <?=date('Y-m-d');?> в <?=date('H:i');?> на <?=$event->Name;?> был зарегистрирован новый участник.

ROCID: <?=$user->RocId;?>
ФИО: <?=$user->GetFullName();?>
<?if (!empty($employment)):?>
Компания: <?=$employment->Company->Name;?>
Должность: <?=$employment->Position;?>
<?endif;?>

Email: <?=!empty($email) ? $email->Email : $user->Email;?>
Телефон: <?=!empty($phones) ? $phones[0]->Phone : 'не указан';?>

--
Письмо отправлено автоматически
www.rocid.ru