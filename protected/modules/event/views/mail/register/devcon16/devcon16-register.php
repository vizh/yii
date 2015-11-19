<?
/**
 * @var \user\models\User $user
 * @var string $password
 */
?>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;"><strong>Здравствуйте <?=$user->getShortName();?>!</strong></p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Благодарим Вас за интерес к конференции DevCon 2016!</p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;"><strong>Вход в Ваш личный кабинет находится по ссылке:</strong><br/>
<?=\CHtml::link('http://msdevcon16.runet-id.com/', 'http://msdevcon16.runet-id.com/')?></p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Для входа в систему используйте ваш email в качестве логина.</p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Пароль: <strong><?php if ($user->Visible):?>Ваш пароль в системе RUNET-ID<?php else:?><?=$password?><?php endif;?></strong></p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Если вы считаете, что это сообщение пришло к вам по ошибке, настоятельно просим сообщить нам.</p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Благодарим за интерес к мероприятиям Microsoft!</p>
