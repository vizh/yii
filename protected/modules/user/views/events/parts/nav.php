<?php
$menu = [
    'index' => \Yii::t('app', 'Мероприятия'),
    'pay' => \Yii::t('app', 'Заказы')
];
?>

<nav class="user-account-nav clearfix">
    <?php foreach($menu as $action => $title):?>
        <a href="<?=$this->createUrl('/user/events/'.$action);?>" <?php if ($current == $action):?>class="current"<?php endif;?>><?=$title;?></a>
    <?php endforeach;?>
</nav>