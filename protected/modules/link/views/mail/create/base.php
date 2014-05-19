<?/** @var \link\models\Link $link */?>
Здравствуйте, <?=$link->Owner->getShortName();?>.

<?=$link->User->getFullName();?> <?if ($link->User->getEmploymentPrimary() !== null):?>(<?=$link->User->getEmploymentPrimary()->Company->Name;?>)<?endif;?> заинтересован в знакомстве с Вами и предлагает встретиться на мероприятии <?=$link->Event->Title;?>.

Если Вы заинтересованы, то при подтверждении встречи укажите наиболее удобное время. В случае, если установление контакта не в ваших интересах, просто проигнорируйте это письмо.
