<!DOCTYPE HTML>
<html>
  <head>
    <title>-РЕГИСТРАЦИЯ- / -МЕРОПРИЯТИЕ- / -МЕРОПРИЯТИЯ- / -RUNET-ID-</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="icon" href="/modules<?php echo $this->layout;?>/favicon.ico">
    <link rel="stylesheet" href="/modules<?php echo $this->layout;?>/stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="/modules<?php echo $this->layout;?>/stylesheets/application.css">
    <script src="/modules<?php echo $this->layout;?>/javascripts/jquery-1.8.2.min.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/jquery-ui-1.9.0.custom.min.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/jquery.ui.autocomplete.html.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/underscore-min.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/backbone-min.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/bootstrap.min.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/jquery.iosslider.min.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/money-format.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/application.js"></script>

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="/modules<?php echo $this->layout;?>/stylesheets/ie/lte-ie-9.css">
      <script src="/modules<?php echo $this->layout;?>/javascripts/ie/jquery.placeholder.min.js"></script>
      <script>$(function() {$("input[placeholder], textarea[placeholder]").placeholder();});</script>
    <![endif]-->
    <!--[if lte IE 8]>
      <link rel="stylesheet" href="/modules<?php echo $this->layout;?>/stylesheets/ie/lte-ie-8.css">
      <script src="/modules<?php echo $this->layout;?>/javascripts/ie/html5shiv.js"></script>
    <![endif]-->
    <!--[if lte IE 7]>
      <link rel="stylesheet" href="/modules<?php echo $this->layout;?>/stylesheets/ie/lte-ie-7.css">
    <![endif]-->
    <script src="/modules<?php echo $this->layout;?>/javascripts/event-calculate-price.js"></script>
    <script src="/modules<?php echo $this->layout;?>/javascripts/event-registration.js"></script>
  </head>
  <body id="event-register">
    <noscript>JavaScript disabled</noscript>
    <header id="header" role="banner">
      <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="/">
              <img src="/images/logo-small.png" width="115" height="10" alt="-RUNET-ID-">
            </a>
            <ul class="nav">
              <li class="item"><a href="/events-list.html">Мероприятия</a></li>
              <li class="item"><a href="http://therunet.com/">Новости</a></li>
              <li class="item"><a href="/competences-list.html">Компетенции</a></li>
              <li class="item"><a href="/jobs-list.html">Работа</a></li>
              <li class="divider-vertical"></li>
              <li class="account dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="/images/content/account-avatar_small.jpg" width="18" height="18" alt="" class="avatar">
                  К. Константинопольский
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu pull-right">
                  <li>
                    <a href="/user-account.html">Личный кабинет</a>
                  </li>
                  <li>
                    <a href="/index.html">Выйти</a>
                  </li>
                </ul>
              </li>
              <li class="divider-vertical"></li>
              <li class="lang dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  RU
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu pull-right">
                  <li>
                    <a href="#">EN</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <?php echo $content;?>
  </body>
</html>