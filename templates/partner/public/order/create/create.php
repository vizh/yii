<ul class="nav nav-pills">
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'order', 'index');?>">Неактивированные счета</a>
    </li>
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'order', 'index');?>?filter=active">Активированные счета</a>
    </li>
    <li>
        <a href="<?=RouteRegistry::GetUrl('partner', 'order', 'search');?>">Поиск</a>
    </li>
    <li class="active">
        <a href="<?=RouteRegistry::GetUrl('partner', 'order', 'create');?>">Выставить счет</a>
    </li>
</ul>

<?php if ( isset ($this->Error)):?>
    <div class="alert alert-error"><?php echo $this->Error;?></div>
<?php endif;?>    
    
<form method="POST" class="">
    <?php echo $this->Form;?>
</form>