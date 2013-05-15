<?php
$menu = array(
  'index' => \Yii::t('app', 'Основная информация'),
  'employment' => \Yii::t('app', 'Места работы'),
  'profinterests' => \Yii::t('app', 'Профессиональные интересы'),
  'contacts' => \Yii::t('app', 'Контактная информация'),
  'photo' => \Yii::t('app', 'Фотография профиля'),
);
;?>

<nav class="user-account-nav clearfix">
  <?foreach($menu as $action => $title):?>
    <a href="<?=$this->createUrl('/user/edit/'.$action);?>" <?if ($current == $action):?>class="current"<?endif;?>><?=$title;?></a>
  <?endforeach;?>
</nav>