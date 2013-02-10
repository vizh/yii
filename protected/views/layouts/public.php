<!DOCTYPE HTML>
<html>
<head>
  <title>-RUNET-ID-</title>
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
                  <a href="/events-list.html">Мероприятия</a>
                </span>
                <span class="span2 item">
                  <a href="#">Исследования</a>
                </span>
                <span class="span2 item">
                  <a href="/about-page.html">О проекте</a>
                </span>
                <span class="span2 item">
                  <a href="#">Реклама</a>
                </span>
                <span class="span2 item">
                  <a href="/jobs-list.html">Работа</a>
                </span>
                <span class="span2 item">
                  <a href="#">Медиа</a>
                </span>
                <span class="span2 item">
                  <a href="#">Соглашение</a>
                </span>
          </nav>
        </div>
      </div>
      <form id="search-footer" class="span4" action="#" role="search">
        <input type="text" class="form-element_text" placeholder="Поиск по людям, компаниям, новостям">
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
        <nav class="b-social pull-left">
          <a href="#" class="item">
            <img src="/images/blank.gif" alt="" class="i-social_small i-social_facebook dark">
          </a>
          <a href="#" class="item">
            <img src="/images/blank.gif" alt="" class="i-social_small i-social_twitter dark">
          </a>
          <a href="#" class="item">
            <img src="/images/blank.gif" alt="" class="i-social_small i-social_vkontakte dark">
          </a>
        </nav>
        <div class="copyright pull-left">
          &copy;&nbsp;2008-2012, ООО &laquo;Интернет Медиа Холдинг&raquo;
        </div>
      </div>
      <div class="development pull-right">
        Разработка: <a href="http://coalla.ru/" title="Агентство Coalla" target="_blank">Coalla</a>
      </div>
    </div>
  </div>
</footer>


<div id="ModalAuth" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <iframe width="620" height="662" src="<?=Yii::app()->createUrl('/oauth/main/auth');?>" frameborder="0"></iframe>
</div>
</body>
</html>