<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo  $this->Title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="Shortcut Icon" href="/images/favicon.ico" type="image/x-icon" />
  <meta name='robots' content='noindex,nofollow' />
  <link rel="stylesheet" type="text/css" href="/css/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/css/partner.css" media="all" />


  <script type="text/javascript" src="/js/libs/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="/css/bootstrap/js/bootstrap.js"></script>

  <?php echo $this->heads['HeadTitle']; ?>
  <?php echo $this->heads['HeadLink']; ?>
  <?php echo $this->heads['HeadMeta']; ?>
  <?php echo $this->heads['HeadScript']; ?>
  <?php echo $this->heads['HeadStyle']; ?>
</head>
<body>

<?if ($this->Account != null && false):
  $router = RouteRegistry::GetInstance();
  $section = $router->GetSection();
  ?>
<div class="container navbar-fixed-top-menu">
  <div class="navbar">
    <div class="navbar-inner">
      <div class="nav-collapse">
        <ul class="nav">
          <li <?if (empty($section) && $router->GetCommand() == 'index'):?>class="active" <?endif;?>><a href="<?=RouteRegistry::GetUrl('partner', '', 'index');?>">Главная</a></li>
          <li <?if ($section == 'order'):?>class="active" <?endif;?>><a href="<?=RouteRegistry::GetUrl('partner', 'order', 'index');?>">Счета</a></li>
          <li <?if ($section == 'user'):?>class="active" <?endif;?>><a href="<?=RouteRegistry::GetUrl('partner', 'user', 'index');?>">Участники</a></li>
          <li <?if ($section == 'coupon'):?>class="active" <?endif;?>><a href="<?=RouteRegistry::GetUrl('partner', 'coupon', 'index');?>">Промо-коды</a></li>
          
          <?php if (true || $_SERVER['REMOTE_ADDR'] == '82.142.129.35'):?>
            <li <?if ($section == 'orderitem'):?>class="active" <?endif;?>><a href="<?=RouteRegistry::GetUrl('partner', 'orderitem', 'index');?>">Заказы</a></li>
          <?php endif;?>
          <!--<li><a href="#">Link</a></li>-->
        </ul>
        <ul class="nav pull-right">
          <li><a href="<?=RouteRegistry::GetUrl('partner', '', 'logout');?>">Выход</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?endif;?>

<div class="container">
  <div class="rocid-logo">
    <h1>ROC<span>ID</span>:// <span class="rocid-logo-suffix">Партнерский интерфейс</span></h1>
  </div>
</div>



<div class="container content-block">

  <h2>Новый адрес партнерского интерфейса: <a href="http://partner.rocid.ru/">http://partner.rocid.ru/</a></h2>

  <?='';//$this->Content;?>
</div>



</body>
</html>