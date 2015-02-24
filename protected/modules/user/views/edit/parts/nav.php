<?php
$menu = [
    'index' => \Yii::t('app', 'Основная информация'),
    //todo: Раскомментировать после тестирования 'education' => \Yii::t('app', 'Образование'),
    'employment' => \Yii::t('app', 'Места работы'),
    'profinterests' => \Yii::t('app', 'Профессиональные интересы'),
    'contacts' => \Yii::t('app', 'Контактная информация'),
    'photo' => \Yii::t('app', 'Фотография профиля'),
];
?>

<nav class="user-account-nav clearfix">
    <?php foreach($menu as $action => $title):?>
        <a href="<?=$this->createUrl('/user/edit/'.$action);?>" <?php if ($current == $action):?>class="current"<?php endif;?>><?=$title;?></a>
    <?php endforeach;?>
</nav>