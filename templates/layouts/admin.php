<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo  $this->Title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="Shortcut Icon" href="/images/favicon.ico" type="image/x-icon" />
  <meta name='robots' content='noindex,nofollow' />
  <link rel="stylesheet" type="text/css" href="/css/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap-setup.css">
  <link rel="stylesheet" type="text/css" href="/css/admin.css" media="all" />
  <link rel="stylesheet" type="text/css" href="/css/css3buttons.css" media="all" />
  <script type="text/javascript" src="/js/libs/jquery-1.6.4.min.js"></script>
  <script type="text/javascript" src="/js/admin/rocid.ajaxloading.js"></script>
  <?php echo $this->heads['HeadTitle']; ?>
  <?php echo $this->heads['HeadLink']; ?>
  <?php echo $this->heads['HeadMeta']; ?>
  <?php echo $this->heads['HeadScript']; ?>
  <?php echo $this->heads['HeadStyle']; ?>
</head>
<body>

<div id="global">
  <header>
    <div id="logo">roc<span class="r">ID</span>://<span class="a">админка</span></div>
    <?php echo $this->Menu;?>
    <div class="cl"></div>
  </header>

  <section class="main">
    <?php echo $this->SubMenu;?>
  </section>
  <?php echo $this->Content; ?>
  <div id="falsebottom"></div>
</div>

<footer>
  
</footer>

<div id="ajax-loading">Загрузка</div>

</body>
</html>