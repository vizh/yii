
  <p><strong>Здравствуйте, <?=$user->getFullName();?></strong>.</p>

  <?if ($type == 'withCode'):?>
      <?php
      $hash = $user->getRecoveryHash();
      $recoveryUrl = \Yii::app()->createAbsoluteUrl('/main/recovery/index', array('runetId' => $user->RunetId, 'hash' => $hash));
      ?>
      <p>Вы или кто-то другой запросил возможность сброса пароля на <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a></p>
      <p>Для сброса пароля введите код: <strong><?=$hash;?></strong>. Или перейдите по ссылке: <a href="<?=$recoveryUrl;?>"><?=$recoveryUrl;?></a></p>
      <p><strong>При вводе кода или перехода по ссылке вам будет сгенерирован и выслан новый пароль отдельным письмом.</strong></p>
      <p>Если вы не хотите сбрасывать пароль просто проигнорируйте это сообщение.</p>
  <?elseif($type == 'withPassword'):?>
      <p>Вы запросили новый пароль на <a href="http://runet-id.com/"><strong>RUNET-ID</strong></a></p>
      <h2>Ваш новый пароль: <?=$password;?></h2>
  <?endif;?>
  <p>С уважением,<br/>команда поддержки RUNET-ID</p>