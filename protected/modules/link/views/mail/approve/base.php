<?/** @var \link\models\Link $link */?>
<p>Здравствуйте, <?=$link->User->getShortName();?>.</p>

<p><?=$link->Owner->getFullName();?> <?if ($link->Owner->getEmploymentPrimary() !== null):?>(<?=$link->Owner->getEmploymentPrimary()->Company->Name;?>)<?endif;?> подтверждает возможность встречи на мероприятии <?=$link->Event->Title;?> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $link->MeetingTime);?>.</p>

<p><strong>Контактная информация <?=$link->Owner->getFullName();?>:</strong><br/>
<?if ($link->Owner->getContactPhone() !== null):?>Телефон: <?=$link->Owner->getContactPhone();?><br/><?endif;?>
Почта: <?=$link->Owner->Email;?></p>