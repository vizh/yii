<!DOCTYPE HTML>
<!--[if IE 8]><html lang="ru-RU" class="no-js ie8"><![endif]-->
<!--[if IE 9]><html lang="ru-RU" class="no-js ie9"><![endif]-->
<html lang="ru-RU" class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link rel="icon" href="/favicon.ico">

  <title>Авторизация / RUNET-ID</title>
</head>
<body class="page_registration">
<script type="text/javascript">
  <?if($this->Account->Id !== \api\models\Account::SelfId):?>
  if (window.top !== window.self) {
    document.write = "";
    setTimeout(function(){document.body.innerHTML='';},1);
    window.self.onload=function(evt){
      document.body.innerHTML='';
    };
  }
  <?endif?>

function fillOAuthUrls(oauth)
{
  oauth.fbUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Facebook))?>';
  oauth.vkUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Vkontakte))?>';
  oauth.twiUrl = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Twitter))?>';
  oauth.gUrl   = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Google))?>';
  oauth.viadeoUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Viadeo))?>';
  oauth.ppUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::PayPal))?>'
}
</script>
<section id="section" role="main">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12 ">
        <div class="block">
          <div class="block_t">RUNET-ID</div>
          <div class="row">
            <div class="span12">
              <div class="block_cnt">
                <?=$content?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
