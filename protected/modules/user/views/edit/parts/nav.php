<?php
$menu = [
    'index' => \Yii::t('app', 'Основная информация'),
    'education' => \Yii::t('app', 'Образование'),
    'employment' => \Yii::t('app', 'Места работы'),
    'profinterests' => \Yii::t('app', 'Профессиональные интересы'),
    'contacts' => \Yii::t('app', 'Контактная информация'),
    'photo' => \Yii::t('app', 'Фотография профиля'),
    'document' => \Yii::t('app', 'Паспортные данные')
];
?>

<nav class="user-account-nav clearfix">
    <?php foreach($menu as $action => $title):?>
        <a href="<?=$this->createUrl('/user/edit/'.$action)?>" <?if($current == $action):?>class="current"<?endif?>><?=$title?></a>
    <?endforeach?>
</nav>