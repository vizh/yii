<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"  xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <title><?php echo  $this->Title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="Shortcut Icon" href="/images/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="/css/style.css?1.1.16" media="all" />
  <link rel="stylesheet" type="text/css" href="/css/mystyle.css?1.1.7" media="all" />
  <script type="text/javascript" src="/js/libs/jquery-1.6.4.min.js"></script>
  <script type="text/javascript" src="/js/libs/underscore-min.js"></script>
  <script type="text/javascript" src="/js/libs/backbone-min.js"></script>
  <script type="text/javascript" src="/js/application.js"></script>

  <?php echo $this->heads['HeadTitle']; ?>
  <?php echo $this->heads['HeadLink']; ?>
  <?php echo $this->heads['HeadMeta']; ?>
  <?php echo $this->heads['HeadScript']; ?>
  <?php echo $this->heads['HeadStyle']; ?>
  <?php echo $this->MetaTags; ?>

  <!-- Google Analitics -->
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-29398696-1']);
    _gaq.push(['_setDomainName', 'rocid.ru']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>

</head>
<body>
<div class="notifications">
  <?php echo $this->ErrorNotices;?>
</div>
<?php echo $this->UserBar; ?>
<div id="wrapper">

  <div id="header">
    <div id="logo">
      <a href="/">
        <?if (isset($this->HeaderLogo)):?>
        <img src="<?=$this->HeaderLogo;?>" alt="">
        <?else:?>
        <img src="/images/logo.png" alt="">
        <?endif;?>
      </a>
    </div>
    <div id="top-menu">
      <ul>
        <li><a href="/news/">Новости</a></li>
        <li><a href="/events/">Мероприятия</a></li>
        <li><a href="/video/">Видео</a></li>
        <li><a href="<?=RouteRegistry::GetUrl('job', '', 'top');?>">Работа</a></li>
        <li><a href="/search/">Поиск</a></li>
        <!--<li><a href="#">Что-то ещё</a></li>-->
        <!--<li><a href="#">Списки</a></li>-->
      </ul>
      <!-- <ul class="bottom">
                 <li><a href="#">Люди</a></li>
                 <li><a href="#">Компании</a></li>
                 <li>
                   <form class="panel-search" action="" method="get" accept-charset="utf-8">
                     <input id="search" class="in-text js-autosuggest-field" value="поиск по сайту" type="text" name="q" />
                     <div class="js-autosuggest-output-container"><div class="js-autosuggest-output hidden"></div></div>
                   </form>
                 </li>
               </ul> -->
    </div>
  </div>
  <div class="clear"></div>
  <!--  ========================================================= end header ================================================ -->
  <?php echo $this->Content; ?>
  <!-- ========================================================= footer ================================================ -->
  <div class="clear"></div>
  <div id="falsebottom"></div>
</div>
<div id="footer">
  <div id="bottom-menu">
    <ul>
      <li><a href="<?=RouteRegistry::GetUrl('main', '', 'about');?>">О проекте</a></li>
      <li><a href="<?=RouteRegistry::GetUrl('main', '', 'agreement');?>">Соглашение</a></li>
      <li><a href="<?=RouteRegistry::GetUrl('main', '', 'ad');?>">Реклама</a></li>
    </ul>
  </div>
  <div id="copyright">
    <p style="padding-bottom: 3px;">Служба технической поддержки: <a href="mailto:users@rocid.ru">users@rocid.ru</a></p>
    <p>© 2008&#150;<?=date('Y');?>, ООО &laquo;Интернет Медиа Холдинг&raquo;</p>
  </div>
  <div id="counters">
    <!--            <a href="#"><img src="/images/li.gif" alt="" /></a>
<a href="#"><img src="/images/li.gif" alt="" /></a>
<a href="#"><img src="/images/li.gif" alt="" /></a>-->
  </div>
  <div id="notamedia">
    <table>
      <tr>
        <td width="50px">Дизайн:</td>
        <td>Notamedia 2009</td>
      </tr>
      <tr>
        <td></td>
        <td>&laquo;Интернет Медиа Холдинг&raquo; 2011</td>
      </tr>
    </table>
    <table style="padding-top: 5px;">
      <tr>
        <td width="50px">Хостинг:</td>
        <td><a target="_blank" href="http://selectel.ru/" title="Selectel"><img src="/images/logo/selectel.gif" alt="Selectel"></a></td>
      </tr>
    </table>
  </div>
</div>
<div id="overlay"></div>
</body>
</html>