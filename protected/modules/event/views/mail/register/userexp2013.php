<?php
/**
 * @var \user\models\User $user
 * @var \event\models\Role $role
 * @var \event\models\Event $event
 * @var \event\models\Participant $participant
 */
?>
Здравствуйте, <?=$user->getShortName();?>.

<?if ($role->Id == 24):?>
Спасибо, что выразили свою заинтересованность в посещении выставки User eXperience 2013.

Для получения доступа к конференционной части мероприятия, вам необходимо приобрести полное двухдневное участие к конференции <?=$user->getFastauthUrl(Yii::app()->createAbsoluteUrl('/pay/cabinet/register', ['eventIdName' => $event->IdName]));?>


User eXperience 2013 - седьмая международная профессиональная конференция, посвященная вопросам юзабилити и User Experience.

Конференция пройдет - 7 и 8 ноября 2013 года в Медиа-центре Mail.ru Group, по адресу г. Москва, Ленинградский проспект д.39, строение 79.
<?else:?>
Вы были успешно зарегистрированы на конференцию User eXperience 2013.

Место проведения.
Основная программа: 7-8 ноября 2013 года в Медиа-центре Mail.Ru Group
Адрес: г. Москва, Ленинградский проспект д.39, строение 79, БЦ «SkyLight»

Мастер-класс: 9 ноября 2013 года, 1С:Лекторий
Адрес: Москва, ул. Селезнёвская  д.34

Для удобного прибытия на площадку и оперативной регистрации на месте советуем Вам распечатать путевой лист:
<?=$participant->getTicketUrl();?>

Ваш билет уникален и не подлежит передаче третьим лицам. Пожалуйста, предъявите его при входе на площадку в распечатанном виде или посредством электронного устройства.

ТАКЖЕ обращаем Ваше внимание, что при себе необходимо обязательно иметь паспорт!

До встречи на мероприятии!
<?endif;?>

Дополнительную информацию можно получить на сайте:
http://2013.userexperience.ru/
 
По всем вопросам можно обращаться: 
info@userexperience.ru
