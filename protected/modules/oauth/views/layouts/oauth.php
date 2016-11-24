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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <title>Авторизация / RUNET-ID</title>
    <script src='//www.google.com/recaptcha/api.js'></script>
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
        oauth.ppUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::PayPal))?>';
        oauth.linkedinUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Linkedin))?>';
        oauth.okUrl  = '<?=$this->createUrl('/oauth/social/request', array('social' => oauth\components\social\ISocial::Ok))?>';
    }
</script>
<section id="section" role="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xs-12 col-sm-offset-3">
                <div class="block">
                    <div class="block_t">RUNET-ID</div>
                    <?=$content?>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>