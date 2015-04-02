<?php
/**
 * @var $this MainController
 * @var $model \oauth\components\form\AuthForm
 * @var $socialProxy \oauth\components\social\Proxy
 * @var $fast string|null
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
    <?if ($fast !== null):?>
    $('#fb_login').trigger('click');
    <?endif;?>

  };

  // Load the SDK Asynchronously
  (function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
  }(document));

  (loadScript('http://cdn.viadeo.com/javascript/sdk.js', function(){
    VD.init({
      apiKey: '<?=\oauth\components\social\Viadeo::AppId;?>',
      status: true,
      cookie: true
    });
  }));
</script>

<?php echo CHtml::beginForm();?>
  <fieldset>
    <legend><?=Yii::t('app', 'Авторизация');?></legend>

    <p><?=Yii::t('app', 'Вы&nbsp;можете авторизоваться при помощи аккаунта RUNET-ID, если являетесь пользователем сервиса:');?></p>
    <div class="control-group <?=$model->hasErrors('Login') ? 'error' : '';?>">
      <?=CHtml::activeTextField($model, 'Login', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Login')));?>
    </div>
    <div class="control-group <?=$model->hasErrors('Password') ? 'error' : '';?>">
      <?=CHtml::activePasswordField($model, 'Password', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Password')));?>
    </div>
    <label class="checkbox clearfix muted">
      <?=CHtml::activeCheckBox($model, 'RememberMe', array('uncheckValue' => null));?><?=$model->getAttributeLabel('RememberMe');?>
      <a href="<?=$this->createUrl('/oauth/main/recover');?>" class="pull-right"><?=Yii::t('app', 'Восстановить пароль');?></a>
    </label>

    <?php echo CHtml::errorSummary($model, '<div class="alert alert-error">', '</div>');?>

    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;<?=Yii::t('app', 'Войти');?></button>
    <p></p>
  </fieldset>
<?php CHtml::endForm();?>
<hr>
<div class="social">
  <p><?=Yii::t('app', 'Или вы&nbsp;можете авторизоваться при помощи учетных записей социальных сетей:');?></p>
  <div class="nowrap">
    <a href="#" id="fb_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__facebook"></i>&nbsp;Facebook</a>
    <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Twitter));?>" id="twi_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__twitter"></i>&nbsp;Twitter</a>
    <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Vkontakte));?>" id="vk_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__vkontakte"></i>&nbsp;<?=Yii::t('app', 'Вконтакте');?></a><br/>
    <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Google));?>" id="g_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__google"></i>&nbsp;Google</a>
    <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::PayPal));?>" id="pp_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__paypal"></i>&nbsp;PayPal</a>
    <!--<a href="#" id="viadeo_login" class="btn social_btn"><i class="ico16 ico16_social ico16_social__google"></i>&nbsp;Viadeo</a>-->
  </div>
</div>

<?if ($socialProxy !== null && $socialProxy->isHasAccess()):?>
  <div class="alert alert-warning">
    Не найдена связь с аккаунтом социальной сети <strong><?=$socialProxy->getSocialTitle();?></strong>. Она будет добавлена после авторизации или <a href="<?=$this->createUrl('/oauth/main/register');?>">регистрации</a> в RUNET-ID.
  </div>
<?endif;?>

<hr>
<p><?=\Yii::t('app', 'Если у&nbsp;вас нет RUNET-ID, вы&nbsp;можете его <a href="{url}">зарегистрировать</a>.', array('{url}' => $this->createUrl('/oauth/main/register')));?></p>