<?php
$menu = array(
  'password' => \Yii::t('app', 'Смена пароля'),
);
;?>

<nav class="user-account-nav clearfix">
  <?foreach($menu as $action => $title):?>
    <a href="<?=$this->createUrl('/user/edit/'.$action);?>" <?if ($current == $action):?>class="current"<?endif;?>><?=$title;?></a>
  <?endforeach;?>
</nav>