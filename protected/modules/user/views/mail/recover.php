<p><strong>Здравствуйте, <?=$user->getFullName();?></strong>.</p>

<?php
$hash = $user->getRecoveryHash();
$recoveryUrl = \Yii::app()->createAbsoluteUrl('/main/recovery/index', array('runetId' => $user->RunetId, 'hash' => $hash));
?>
<p>Вы или кто-то другой запросил возможность сброса пароля на <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a></p>
<p>Для сброса пароля введите код:</p>
<p style="text-align: center;font-size: 20px; font-weight: bold;"><?=$hash;?></p>
<p>Если вы не хотите сбрасывать пароль просто проигнорируйте это сообщение.</p>

<p>С уважением,<br/>команда поддержки RUNET-ID</p>