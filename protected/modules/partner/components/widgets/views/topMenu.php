<?if (\Yii::app()->partner->getAccount() != null):
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
          <li <?if ($section == 'orderitem'):?>class="active" <?endif;?>><a href="<?=RouteRegistry::GetUrl('partner', 'orderitem', 'index');?>">Заказы</a></li>
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