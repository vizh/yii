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
  <?php echo $this->UserBar; ?>
  <?php echo $this->Content; ?>
</div>

</body>
</html>
