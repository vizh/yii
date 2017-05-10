<h3>Здравствуйте, <?=$user->getFullName()?>!</h3>

<p>Вы&nbsp;&mdash; зарегистрированный участник мероприятия:&nbsp;<strong><?=$user->Participants[0]->Event->Title?></strong></p>

<p>Ваш статус:&nbsp;<strong><?=$user->Participants[0]->Role->Title?></strong></p>

<p>Ждем Вас на площадке&nbsp;<strong>DEWORKACY Красный Октябрь, 6 этаж (Москва, Берсеневская набережная, 6, стр.&nbsp;3.)&nbsp;</strong></p>
