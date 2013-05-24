<?php
/**
 * @var $user \user\models\User
 */
?>

<div class="row-fluid">
  <div class="span8 offset2">
    <div class="alert alert-success">
      <h3>Пользователи успешно объеденены</h3>

      <p>Посмотреть профиль: <a class="large" target="_blank" href="<?=$user->getUrl();?>"><?=$user->RunetId;?></a></p>
    </div>
  </div>
</div>