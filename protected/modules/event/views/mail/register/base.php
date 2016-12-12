<?php
/**
 *  @var \event\models\Event $event
 *  @var \user\models\User $user
 *  @var \event\models\Participant $participant
 *  @var \event\models\Role $role
 */
?>
<h2 style='font-family: HelveticaNeue-Light,"Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif; color: rgb(0, 0, 0); font-weight: 500; font-size: 23px; margin: 10px 0px; padding: 0px; line-height: 1.3;'>Здравствуйте!</h2>
<p style="line-height: 20.7999992370605px;">Спасибо за регистрацию на&nbsp;<strong><?=\CHtml::link($event->Title, $event->getUrl())?></strong></p>
<p style="line-height: 20.7999992370605px;">
    Ваш статус на мероприятии<?if(!empty($participant->Part)):?> (<?=$participant->Part->Title?>)<?endif?>: <strong><?=$role->Title?></strong>
</p>

<?if(isset($event->MailRegisterAdditionalText)):?>
    <?=$event->MailRegisterAdditionalText?>
<?endif?>

<p style="line-height: 20.7999992370605px;">Дата и время проведения: <strong><?$this->widget('\event\widgets\Date', ['event' => $event])?>.</strong></p>
<?if($event->getContactAddress() !== null):?>
    <?$short = $event->getContactAddress()->getShort()?>
    <p style="line-height: 20.7999992370605px;">Место проведения: <strong><span itemprop="streetAddress" style="font-family: Roboto, 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 20px;"><?=$event->getContactAddress()->Place?><?if(!empty($short)):?> (<?=$short?>)<?endif?></span></strong></p>
<?endif?>
<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 10px;">
    <p style="margin-bottom: 5px">Пожалуйста, сохраните на телефон или распечатайте ваш электронный билет:</p>

    <p style="margin-top: 0"><a href="<?=$participant->getTicketUrl()?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #60A729; margin: 0 10px 0 0; padding: 0; border-color: #60A729; border-style: solid; border-width: 10px 40px;">Электронный билет</a></p>
</div>

<p>Ваш билет уникален и не подлежит передаче третьим лицам.</p>