<?
/**
 * @var \event\models\Participant $participant
 */
?>

<p>Добрый день,&nbsp;<?=$user->getShortName();?>!</p>

<p>Вы зарегистрированы на мероприятие&nbsp;PGCONF.RUSSIA 2015!</p>

<p>Ваш статус:&nbsp;<?=$role->Title;?> - <strong>данный статус не даёт право участия в конференции.&nbsp;</strong></p>

<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 10px;">
<p style="margin-bottom: 5px">Пожалуйста, оплатите своё&nbsp;участие для получения полноценного статуса:</p>

<p style="margin-top: 0"><a href="<?=$participant->User->getFastauthUrl('http://pay.runet-id.com/register/pgcr15/')?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Оплатить участие</a></p>
</div>

<p>&nbsp;</p>
