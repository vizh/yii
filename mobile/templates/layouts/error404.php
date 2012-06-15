<!DOCTYPE html>
<html>
<head>
  <title><?php echo $this->Title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name='robots' content='noindex,nofollow' />


  <!--<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.0b2.css" media="all" />
  <script type="text/javascript" src="/js/libs/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="/js/libs/jquery.mobile-1.0b2.min.js"></script>-->

  <link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.0a2.css" media="all" />
  <link rel="stylesheet" type="text/css" href="/css/style.mobile.css" media="all" />
  <script type="text/javascript" src="/js/libs/jquery-1.4.4.min.js"></script>
  <script type="text/javascript" src="/js/libs/jquery.mobile-1.0a2.min.js"></script>
  <script type="text/javascript" src="/js/mobile.functions.js"></script>

</head>
<body>

<div data-role="page" data-theme="f">
  <div data-role="content">
  <ul data-role="listview" class="event-list" data-splittheme="f">
    <li data-role="list-divider" class="head-event"><h1 class="normal-whitespace">404</h1></li>
  </ul>
  <p class="event-info">
    Страница, которую вы ищете, не существует либо устарела.
  </p>
  <ul class="event-list" data-role="listview" data-splittheme="f">
    <li data-role="list-divider" class="head-event event-info-divider"></li>
    <li>
      <h3 class="normal-whitespace"><a href="/">Вернуться на главную страницу</a></h3>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>
  </ul>
</div>
</div>

</body>
</html>