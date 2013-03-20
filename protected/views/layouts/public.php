<!DOCTYPE HTML>
<html>
<head>
  <title><?=CHtml::encode($this->pageTitle);?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link rel="icon" href="/favicon.ico">
  <!--[if lte IE 9]>
  <link rel="stylesheet" href="/stylesheets/ie/lte-ie-9.css">
  <![endif]-->
  <!--[if lte IE 8]>
  <link rel="stylesheet" href="/stylesheets/ie/lte-ie-8.css">
  <script src="/javascripts/ie/html5shiv.js"></script>
  <![endif]-->
  <!--[if lte IE 7]>
  <link rel="stylesheet" href="/stylesheets/ie/lte-ie-7.css">
  <![endif]-->
</head>
<body id="<?php echo $this->bodyId;?>">
<noscript>JavaScript disabled</noscript>
<header id="header" role="banner">
  <div class="navbar navbar-fixed-top navbar-inverse">
    <?php $this->widget('application\widgets\Navbar');?>
    <?php $this->widget('application\widgets\Searchbar');?>
  </div>
</header>

<section id="section" role="main">
  <?php echo $content;?>
</section>

<footer id="footer" role="contentinfo">
  <div class="b-events-type">
    <div class="container units">
      <div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_conference">
        <p class="caption">Конференция</p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_training">
        <p class="caption">Семинар тренинг</p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_webinar">
        <p class="caption">Вебинар</p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_roundtable">
        <p class="caption">Круглый стол</p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_confpartner">
        <p class="caption">Партнерская конференция</p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_contestprize">
        <p class="caption">Конкурс премия</p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_eventsother">
        <p class="caption">Другие мероприятия</p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="span8">
        <div class="row">
          <nav class="nav" role="navigation">
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/about');?>">О проекте</a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/adv');?>">Реклама</a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/agreement');?>">Соглашение</a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/pay');?>">Оплата</a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/event/list/index');?>">Мероприятия</a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/company/list/index');?>">Компании</a>
            </span>
          </nav>
        </div>
      </div>
      <form id="search-footer" class="span4" action="<?=$this->createUrl('/search/result/index');?>" role="search">
        <input type="text" class="form-element_text" name="term" placeholder="Поиск по людям, компаниям, новостям">
        <input type="image" class="form-element_image pull-right" src="/images/search-type-image-dark.png" width="20" height="19">
      </form>
    </div>
  </div>

  <div class="logo-divider">
    <img src="/images/logo-footer.png" width="200" height="20" alt="" class="logo">
  </div>

  <div class="container">
    <div class="clearfix">
      <div class="clearfix pull-left">
        <div class="copyright pull-left">
          &copy;&nbsp;2008-<?=date('Y')?>, ООО &laquo;Интернет Медиа Холдинг&raquo;
        </div>
      </div>
      <div class="development pull-right">
        Разработка и поддержка: <a href="http://internetmediaholding.com" title="Internet Media Holding" target="_blank">Internet Media Holding</a><br />
        Дизайн: <a href="http://coalla.ru/" title="Агентство Coalla" target="_blank">Coalla</a>
      </div>
    </div>
  </div>
</footer>

<div id="ModalAuth" class="modal hide fade" style="width: 620px; outline-style: none;" data-src="<?=Yii::app()->createUrl('/oauth/main/auth');?>" data-width="640" data-height="662" tabindex="-1" role="dialog"></div>
</body>
</html>