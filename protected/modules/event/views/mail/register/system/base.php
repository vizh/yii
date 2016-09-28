<p>На мероприятие <?=$event->Title?> успешно зарегистрирован новый пользователь.</p>

<p><strong>Роль:</strong><br/>
<?=$role->Title?></p>


<p><strong>Данные пользователя:</strong><br/>
RUNET-ID пользователя: <?=$user->RunetId?><br/>
Имя: <?=$user->getFullName()?> <?if($user->getEmploymentPrimary() !== null):?>(<?=$user->getEmploymentPrimary()->Company->Name?>)<?endif?><br/>
E-Mail: <?=$user->Email?></br>
</p>

<p>--<br/>
Письмо сгенерировано автоматически.</p>
