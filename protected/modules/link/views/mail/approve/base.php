<?/** @var \link\models\Link $link */?>
Здравствуйте, <?=$link->User->getShortName();?>.

<?=$link->Owner->getFullName();?> <?if ($link->Owner->getEmploymentPrimary() !== null):?>(<?=$link->Owner->getEmploymentPrimary()->Company->Name;?>)<?endif;?> подтверждает возможность встречи на мероприятии <?=$link->Event->Title;?> <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy HH:mm', $link->MeetingTime);?>.

Контактная информация <?=$link->Owner->getFullName();?>:
<?if ($link->Owner->getContactPhone() !== null):?>Телефон: <?=$link->Owner->getContactPhone();?>

<?endif;?>
Почта: <?=$link->Owner->Email;?>