<?php
$menu = [
    'index' => \Yii::t('app', 'Мероприятия'),
    'pay' => \Yii::t('app', 'Заказы')
];
?>

<nav class="user-account-nav clearfix">
    <?php foreach($menu as $action => $title):?>
        <a href="<?=$this->createUrl('/user/events/'.$action)?>" <?if($current == $action):?>class="current"<?endif?>><?=$title?></a>
    <?endforeach?>
</nav>