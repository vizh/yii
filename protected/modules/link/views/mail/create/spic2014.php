<?/** @var \link\models\Link $link */?>
<p>Здравствуйте, <?=$link->Owner->getShortName();?>.</p>

<p><?=$link->User->getFullName();?> <?if ($link->User->getEmploymentPrimary() !== null):?>(<?=$link->User->getEmploymentPrimary()->Company->Name;?>)<?endif;?> заинтересован в знакомстве с Вами и предлагает встретиться на мероприятии <?=$link->Event->Title;?>.</p>

<p>Если Вы заинтересованы, то при подтверждении встречи укажите наиболее удобное время. В случае, если установление контакта не в ваших интересах, просто проигнорируйте это письмо.</p>

<p style="text-align: center;">
  <a href="<?=$link->Owner->getFastauthUrl('http://2014.sp-ic.ru/my/link/?widget_link_action=cabinet');?>" style="display: block; text-decoration: none; background: #e41937; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">ПОДТВЕРДИТЬ ВСТРЕЧУ</a>
</p>