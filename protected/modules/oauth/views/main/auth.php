<?php
/**
 * @var $this MainController
 * @var $model \oauth\components\form\AuthForm
 */
?>

<div id="fb-root"></div>
<script>
  // Additional JS functions here
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?=\oauth\components\social\Facebook::AppId;?>', // App ID
      channelUrl : '//<?=RUNETID_HOST;?>/files/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional init code here

  };

  // Load the SDK Asynchronously
  (function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
  }(document));
</script>

<?php echo CHtml::beginForm();?>
  <fieldset>
    <legend>Авторизация</legend>
    <p>Вы&nbsp;можете авторизоваться при помощи аккаунта RUNET-ID, если являетесь пользователем сервиса:</p>
    <div class="control-group <?=$model->hasErrors('Login') ? 'error' : '';?>">
      <?=CHtml::activeTextField($model, 'Login', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Login')));?>
    </div>
    <div class="control-group <?=$model->hasErrors('Password') ? 'error' : '';?>">
      <?=CHtml::activePasswordField($model, 'Password', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Password')));?>
    </div>
    <label class="checkbox clearfix muted">
      <?=CHtml::activeCheckBox($model, 'RememberMe', array('uncheckValue' => null));?><?=$model->getAttributeLabel('RememberMe');?>
      <a href="./recover-password.html" class="pull-right">Восстановить пароль</a>
    </label>

    <?php echo CHtml::errorSummary($model, '<div class="alert alert-error">', '</div>');?>

    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Войти</button>
    <p></p>
  </fieldset>
<?php CHtml::endForm();?>
<hr>
<div class="social">
  <p>Или вы&nbsp;можете авторизоваться при помощи учетных записей социальных сетей:</p>
  <div class="tx-c nowrap">
    <a href="#" id="fb_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__facebook"></i>&nbsp;Facebook</a>
    <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Twitter));?>" id="twi_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__twitter"></i>&nbsp;Twitter</a>
    <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Vkontakte));?>" id="vk_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__vkontakte"></i>&nbsp;Вконтакте</a>
  </div>
</div>
<hr>
<p>Если у&nbsp;вас нет RUNET-ID, вы&nbsp;можете его <a href="<?=$this->createUrl('/oauth/main/register');?>">зарегистрировать</a>.</p>