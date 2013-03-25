<?php
$menu = array(
  'index' => \Yii::t('app', 'Основная информация'),
  'photo' => \Yii::t('app', 'Фотография профиля'),
  'employment' => \Yii::t('app', 'Карьера')
);
;?>

<nav class="user-account-nav clearfix">
  <?foreach($menu as $action => $title):?>
    <a href="<?=$this->createUrl('/user/edit/'.$action);?>" <?if ($current == $action):?>class="current"<?endif;?>><?=$title;?></a>
  <?endforeach;?>
</nav>