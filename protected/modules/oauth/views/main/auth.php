<?php
/**
 * @var $this MainController
 */
?>

<form action="./request.html">
  <fieldset>
    <legend>Авторизация</legend>
    <p>Вы&nbsp;можете авторизоваться при помощи аккаунта RUNET-ID, если являетесь пользователем сервиса:</p>
    <input type="text" placeholder="Эл. почта или RUNET-ID" class="span4">
    <input type="text" placeholder="Пароль" class="span4">
    <label class="checkbox clearfix muted">
      <input type="checkbox">Запомнить меня
      <a href="./recover-password.html" class="pull-right">Восстановить пароль</a>
    </label>
    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Войти</button>
    <p></p>
  </fieldset>
</form>
<hr>
<div class="social">
  <p>Или вы&nbsp;можете авторизоваться при помощи учетных записей социальных сетей:</p>
  <div class="tx-c nowrap">
    <button class="btn social_btn"><i class="ico16 ico16_social ico16_social__facebook"></i>&nbsp;Facebook</button>
    <button class="btn social_btn"><i class="ico16 ico16_social ico16_social__twitter"></i>&nbsp;Twitter</button>
    <button class="btn social_btn"><i class="ico16 ico16_social ico16_social__vkontakte"></i>&nbsp;Вконтакте</button>
  </div>
</div>
<hr>
<p>Если у&nbsp;вас нет RUNET-ID, вы&nbsp;можете его <a href="<?=$this->createUrl('/oauth/main/register');?>">зарегистрировать</a>.</p>








<?php echo CHtml::beginForm();?>
  <?php echo CHtml::errorSummary($model, '<div class="alert alert-error m-bottom_20">', '</div>');?>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'RocIdOrEmail');?>:</label>
    <div class="controls">
      <?php echo CHtml::activeTextField($model, 'RocIdOrEmail');?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'Password');?>:</label>
    <div class="controls">
      <?php echo CHtml::activePasswordField($model, 'Password');?>
    </div>
  </div>
  <div class="control-group">
    <div class="controls clearfix">
      <?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-success f-left'));?>
      <?php echo CHtml::button('Отмена', array('class' => 'btn btn-cancel'));?>
    </div>
  </div>
<?php CHtml::endForm();?>

<a href="<?=$fbUrl;?>">Фейсбук</a> &nbsp;&nbsp;&nbsp;&nbsp;  <a href="<?=$twiUrl;?>">Твиттер</a>