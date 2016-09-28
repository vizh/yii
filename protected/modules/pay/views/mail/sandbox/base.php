<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>RUNET-ID: экспресс оплата</title>
</head>
<body style="margin: 0">
<p><strong>Уважаемый пользователь</strong>,</p>
<p>Вы успешно добавлены на <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a> для экспресс-оплаты.</p>

<h2>Ваша ссылка для экспресс-оплаты в любой момент:</h2>
<div style="padding: 10px; margin-left: 10px; font-size: 120%; display:inline-block;">
  <div style="margin-bottom: 5px;"><a href="<?=$user->getFastauthUrl(isset(\Yii::app()->params['TemporaryUserRedirect']) ? \Yii::app()->params['TemporaryUserRedirect'] : '')?>">Платежный кабинет</a></div>
</div>

<h2>Способы оплаты</h2>

<p><strong>Для физических лиц</strong> с банковской карты (Visa или MasterCard), через Яндекс.Деньги, через WebMoney, через PayPal, через QIWI Кошелек, через банковскую квитанцию</p>

<p><strong>Для юридических лиц</strong> доступна возможность выставить счет для оплаты.</p>

<h2>Поддержка</h2>
<p style="margin-bottom: 80px;">По всем вопросам работы сервиса вы всегда можете обратиться в нашу службу поддержки пользователей:<br/><a href="mailto:support@runet-id.com">support@runet-id.com</a></p>

С уважением,<br/>
команда поддержки RUNET-ID
<p style="color: #999999;"><small>RUNET-ID- сервис для интернет-пользователей, объединяющий в себе удобную систему регистрации на мероприятия медиа- и интернет-индустрии, а также позволяющий всем участникам системы формировать хронологию своего профессионального роста и отображать компетенции в различных сферах.</small></p>
</body>
</html>