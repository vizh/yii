<?/** @var \link\models\Link $link */?>
<p>Здравствуйте, <?=$link->Owner->getShortName()?>.</p>

<p><?=$link->User->getFullName()?> <?if($link->User->getEmploymentPrimary() !== null):?>(<?=$link->User->getEmploymentPrimary()->Company->Name?>)<?endif?> заинтересован в знакомстве с Вами и предлагает встретиться на мероприятии <?=$link->Event->Title?>.</p>

<p>Если Вы заинтересованы, то при подтверждении встречи укажите наиболее удобное время. В случае, если установление контакта не в ваших интересах, просто проигнорируйте это письмо.</p>
