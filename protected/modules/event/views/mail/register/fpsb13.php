<?php
/**
 * @var \user\models\User $user
 * @var \event\models\Participant $participant
 * 
 */
?>

Здравствуйте, <?=$user->getShortName();?>!

Вы – зарегистрированный участник III Инновационного форума Промсвязьбанка

//МЕСТО ПРОВЕДЕНИЯ
22 ноября 2013 года в центре Digital October
Адрес: г. Москва, Берсеневская наб. д.6, стр 3.


Для удобного прибытия на площадку и оперативной регистрации на месте советуем Вам распечатать путевой лист:
<?=$participant->getTicketUrl();?>


Ваш билет уникален и не подлежит передаче третьим лицам. Пожалуйста, предъявите его при входе на площадку в распечатанном виде или посредством электронного устройства.

P.S. Во вложении к письму Passbook-билет, который может быть открыт на устройствах под управлением iOS 6-7 или Android. Если вы являетесь обладателем такого устройства, то можете сохранить билет в специальном приложении и предъявить на регистрации вместо путевого листа. Для пользователей Android требуется предварительно скачать приложение из Google Play (например, Pass2U).

До встречи на мероприятии!


--
С уважением,
Оргкомитет III Инновационного форума Промсвязьбанка