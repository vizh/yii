<!DOCTYPE HTML>
<html>
  <head>
    <title>-RUNET-ID-</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="icon" href="/modules<?=$this->layout?>/favicon.ico">
    <link rel="stylesheet" href="/modules<?=$this->layout?>/stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="/modules<?=$this->layout?>/stylesheets/application.css">
    <script src="/modules<?=$this->layout?>/javascripts/jquery-1.8.2.min.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/jquery-ui-1.9.0.custom.min.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/jquery.ui.autocomplete.html.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/underscore-min.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/backbone-min.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/bootstrap.min.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/jquery.iosslider.min.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/money-format.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/application.js"></script>

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="/modules<?=$this->layout?>/stylesheets/ie/lte-ie-9.css">
      <script src="/modules<?=$this->layout?>/javascripts/ie/jquery.placeholder.min.js"></script>
      <script>$(function() {$("input[placeholder], textarea[placeholder]").placeholder();});</script>
    <![endif]-->
    <!--[if lte IE 8]>
      <link rel="stylesheet" href="/modules<?=$this->layout?>/stylesheets/ie/lte-ie-8.css">
      <script src="/modules<?=$this->layout?>/javascripts/ie/html5shiv.js"></script>
    <![endif]-->
    <!--[if lte IE 7]>
      <link rel="stylesheet" href="/modules<?=$this->layout?>/stylesheets/ie/lte-ie-7.css">
    <![endif]-->
    <script src="/modules<?=$this->layout?>/javascripts/event-calculate-price.js"></script>
    <script src="/modules<?=$this->layout?>/javascripts/event-registration.js"></script>
  </head>
  <body id="<?=$this->layoutBodyId?>">
    <noscript>JavaScript disabled</noscript>
    <header id="header" role="banner">
      <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="/">
              <img src="/modules<?=$this->layout?>/images/logo-small.png" width="115" height="10" alt="-RUNET-ID-">
            </a>
            <ul class="nav">
              <li class="account dropdown pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src=" <?=\Yii::app()->user->getCurrentUser()->GetMiniPhoto()?>" width="18" height="18" alt="" class="avatar">
                  <?=\Yii::app()->user->getCurrentUser()->GetFullName()?>
                  <b class="caret"></b>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <?=$content?>
  </body>
</html>