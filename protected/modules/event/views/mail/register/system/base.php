На мероприятие <?=$event->Title;?> успешно зарегистрирован новый пользователь.

Роль:
<?=$role->Title;?>


Данные пользователя:
RUNET-ID пользователя: <?=$user->RunetId;?>

Имя: <?=$user->getFullName();?> <?if($user->getEmploymentPrimary() !== null):?>(<?=$user->getEmploymentPrimary()->Company->Name;?>)<?endif;?>

E-Mail: <?=$user->Email;?>


--
Письмо сгенерировано автоматически.
