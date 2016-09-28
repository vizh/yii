<?php
$menu = array(
  'password' => \Yii::t('app', 'Смена пароля'),
  'indexing' => \Yii::t('app', 'Индексация в поисковых системах'),
  'subscription' => \Yii::t('app', 'Управление подпиской'),
  'connect' => \Yii::t('app', 'Привязка к социальным сетям')
);
?>

<nav class="user-account-nav clearfix">
  <?foreach($menu as $action => $title):?>
    <a href="<?=$this->createUrl('/user/setting/'.$action)?>" <?if($current == $action):?>class="current"<?endif?>><?=$title?></a>
  <?endforeach?>
</nav>