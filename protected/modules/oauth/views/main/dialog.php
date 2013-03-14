<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 */
?>

<?=CHtml::beginForm($this->createUrl('/oauth/main/dialog'));?>
  <legend>Здравствуйте, <a target="_blank" href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $user->RunetId));?>"><?=$user->getFullName();?></a></legend>
  <p>Сайт <?=$event->Title;?> запрашивает доступ к&nbsp;вашему аккаунту для использования данных профиля в&nbsp;целях авторизации:</p>
  <br>
  <div class="tx-c">
    <a href="./authorization.html" class="btn">Отмена</a>
    &nbsp;
    <button type="submit" class="btn btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Разрешить</button>
  </div>
<?=CHtml::endForm();?>