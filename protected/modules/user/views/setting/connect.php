<?=$this->renderPartial('parts/title')?>
<?Yii::app()->getClientScript()->registerCssFile('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')?>
<script type="text/javascript">
  function fillOAuthUrls(oauth) {
    oauth.fbUrl  = '<?=$this->createUrl('/user/setting/connect', array('action' => 'connect', 'social' => \oauth\components\social\ISocial::Facebook))?>';
    oauth.vkUrl  = '<?=$this->createUrl('/user/setting/connect')?>';
    oauth.ppUrl  = '<?=$this->createUrl('/user/setting/connect')?>';
    oauth.twiUrl = '<?=$this->createUrl('/user/setting/connect')?>';
    oauth.gUrl   = '<?=$this->createUrl('/user/setting/connect')?>';
    oauth.LinkedinUrl   = '<?=$this->createUrl('/user/setting/connect')?>';
  }
</script>

<div class="user-account-settings">
  <div class="clearfix">
    <div class="container">
      <div class="row">
        <div class="span3">
          <?=$this->renderPartial('parts/nav', array('current' => $this->getAction()->getId()))?>
        </div>
        <div class="span9">
          <div class="b-form">
            <div class="form-header">
              <h4><?=\Yii::t('app', 'Привязка к социальным сетям')?></h4>
            </div>
            <div class="m-bottom_20">
            <?foreach($connects as $connect):?>
              <?

              if ($connect !== null):?>
                <div class="m-bottom_10">
                  <?if($connect->Social->Id == \oauth\components\social\ISocial::Facebook):?>
                    <i class="fa fa-facebook-official"></i>
                  <?elseif ($connect->Social->Id == \oauth\components\social\ISocial::Twitter):?>
                    <i class="fa fa-twitter-square"></i>
                  <?elseif ($connect->Social->Id == \oauth\components\social\ISocial::Vkontakte):?>
                    <i class="fa fa-vk"></i>
                  <?elseif ($connect->Social->Id == \oauth\components\social\ISocial::Google):?>
                    <i class="fa fa-google-plus-square"></i>
                  <?elseif ($connect->Social->Id == \oauth\components\social\ISocial::PayPal):?>
                    <i class="fa fa-paypal"></i>
                  <?elseif ($connect->Social->Id == \oauth\components\social\ISocial::Linkedin):?>
                      <i class="fa fa-linkedin-square"></i>
                  <?endif?>
                  <a class="text-error" href="<?=$this->createUrl('/user/setting/connect', array('social' => $connect->Social->Id, 'action' => 'disconnect'))?>"><?=\Yii::t('app', 'Отключить')?></a>
                </div>
              <?endif?>
            <?endforeach?>
            </div>

            <p><?=\Yii::t('app', 'Привязка учетной записи на RUNET&mdash;ID к аккаунту в социальных сетях даст возможность входить на сайт с помощью одного клика.')?></p>
            <?foreach($connects as $socialId => $connect):?>
              <?if($socialId == \oauth\components\social\ISocial::Facebook):?>
                <?if($connect === null):?>
                  <div id="fb-root"></div>
                  <script type="text/javascript">
                    window.fbAsyncInit = function() {
                      FB.init({
                        appId      : '<?=\oauth\components\social\Facebook::AppId?>', // App ID
                        channelUrl : '//<?=RUNETID_HOST?>/files/channel.html', // Channel File
                        status     : true, // check login status
                        cookie     : true, // enable cookies to allow the server to access the session
                        xfbml      : true  // parse XFBML
                      });
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
                  <a class="btn" href="<?=$this->createUrl('/user/setting/connect', array('social' => oauth\components\social\ISocial::Facebook,  'action' => 'connect'))?>" id="fb_login"><i class="fa fa-facebook-official"></i> Facebook</a>
                <?endif?>
              <?elseif ($socialId == \oauth\components\social\ISocial::Twitter):?>
                <?if($connect === null):?>
                  <a class="btn" href="<?=$this->createUrl('/user/setting/connect', array('social' => oauth\components\social\ISocial::Twitter,  'action' => 'connect'))?>" id="twi_login"><i class="fa fa-twitter-square"></i> Twitter</a>
                <?endif?>
              <?elseif ($socialId == \oauth\components\social\ISocial::Vkontakte):?>
                <?if($connect === null):?>
                  <a class="btn" href="<?=$this->createUrl('/user/setting/connect', array('social' => oauth\components\social\ISocial::Vkontakte,  'action' => 'connect'))?>" id="vk_login"><i class="fa fa-vk"></i> Вконтакте</a>
                <?endif?>
              <?elseif ($socialId == \oauth\components\social\ISocial::Google):?>
                <?if($connect === null):?>
                  <a class="btn" href="<?=$this->createUrl('/user/setting/connect', array('social' => oauth\components\social\ISocial::Google,  'action' => 'connect'))?>" id="g_login"><i class="fa fa-google-plus-square"></i> Google</a>
                <?endif?>
              <?elseif ($socialId == \oauth\components\social\ISocial::PayPal):?>
                <?if($connect === null):?>
                  <a class="btn" href="<?=$this->createUrl('/user/setting/connect', array('social' => oauth\components\social\ISocial::PayPal,  'action' => 'connect'))?>" id="pp_login"><i class="fa fa-paypal"></i> PayPal</a>
                <?endif?>


                <?elseif ($socialId == \oauth\components\social\ISocial::Linkedin):?>
                <?if($connect === null):?>
                    <a class="btn" href="<?=$this->createUrl('/user/setting/connect', array('social' => oauth\components\social\ISocial::Linkedin,  'action' => 'connect'))?>" id="li_login"><i class="fa fa-linkedin-square"></i> LinkedIn</a>
                <?endif?>
              <?endif?>
            <?endforeach?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
