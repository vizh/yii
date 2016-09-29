<?/** @var \user\models\User $user */?>
<p>На мероприятие "<a href="<?=$event->getUrl()?>"><?=$event->Title?></a>" была подана заявка на участие:</p>
<p>
<strong>Данные пользователя:</strong><br/>
Ф.И.О.: <a href="<?=$user->getUrl()?>"><?=$user->getFullName()?></a><br/>
Email: <?=$user->Email?><br/>
<?if($user->getContactPhone() !== null):?>
Тел.: <?=$user->getContactPhone()?><br/>
<?endif?>
<?
$employment = $user->getEmploymentPrimary();
if ($employment !== null):?>
Место работы: <?=$employment->Company->Name.(!empty($employment->Position) ? ', '.$employment->Position : '')?><br/>
<?endif?>
</p>
<p><a href="<?=$this->createUrl('/partner/user/invite/')?>">Перейти на страницу модерирования заявок</a></p>

