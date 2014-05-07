<!DOCTYPE HTML>
<html>
<head>
  <title><?=CHtml::encode($this->pageTitle);?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="google-site-verification" content="j6z-Xgf-Q_q6jFA-UANgpdjIdqPN7J43TiepOX-58EM" />
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
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
    <?$this->widget('application\widgets\Navbar');?>
    <?$this->widget('application\widgets\Searchbar');?>
    <?if (isset($this->navbar) && !empty($this->navbar)):?>
      <?=$this->navbar;?>
    <?endif;?>
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
        <p class="caption"><?=Yii::t('app', 'Конференция');?></p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_training">
        <p class="caption"><?=Yii::t('app', 'Семинар тренинг');?></p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_webinar">
        <p class="caption"><?=Yii::t('app', 'Вебинар');?></p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_roundtable">
        <p class="caption"><?=Yii::t('app', 'Круглый стол');?></p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_confpartner">
        <p class="caption"><?=Yii::t('app', 'Партнерская конференция');?></p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_contestprize">
        <p class="caption"><?=Yii::t('app', 'Конкурс премия');?></p>
      </div
          ><div class="unit">
        <img src="/images/blank.gif" alt="" class="i-event_large i-event_eventsother">
        <p class="caption"><?=Yii::t('app', 'Другие мероприятия');?></p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="span8">
        <div class="row">
          <nav class="nav" role="navigation">
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/about');?>"><?=Yii::t('app', 'О проекте');?></a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/adv');?>"><?=Yii::t('app', 'Реклама');?></a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/agreement');?>"><?=Yii::t('app', 'Соглашение');?></a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/pay');?>"><?=Yii::t('app', 'Оплата');?></a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/event/list/index');?>"><?=Yii::t('app', 'Мероприятия');?></a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/company/list/index');?>"><?=Yii::t('app', 'Компании');?></a>
            </span>
            <span class="span2 item">
              <a href="<?=$this->createUrl('/page/info/contacts');?>"><?=Yii::t('app', 'Контакты');?></a>
            </span>
          </nav>
        </div>
      </div>
      <form id="search-footer" class="span4" action="<?=$this->createUrl('/search/result/index');?>" role="search">
        <input type="text" class="form-element_text" name="term" placeholder="<?=Yii::t('app', 'Поиск по людям, компаниям, новостям');?>">
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
        <div class="development pull-left">
          Оплата за участие в мероприятиях<br/>осуществляется при поддержке <a href="http://payonline.ru" target="_blank">PayOnline</a> и <a href="http://uniteller.ru" target="_blank">Uniteller</a><br /><br />
          <img src="/img/pay/icon-visa.png" alt="VISA"/> <img src="/img/pay/icon-mastercard.png" alt="Master Card"/>
        </div>
      </div>
      <div class="development pull-right">
        &copy;&nbsp;2008-<?=date('Y')?>, ООО &laquo;РУВЕНТС&raquo;<br />
        Разработка и поддержка: <a href="http://internetmediaholding.com" title="Internet Media Holding" target="_blank">Internet Media Holding</a><br />
        Дизайн: <a href="http://coalla.ru/" title="Агентство Coalla" target="_blank">Coalla</a>
      </div>
    </div>
  </div>
</footer>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-43416013-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter23089027 = new Ya.Metrika({id:23089027, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/23089027" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<?$this->widget('\application\widgets\ModalAuth');?>
</body>
</html>