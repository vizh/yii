<?php
/**
 * @var $user \user\models\User
 * @var $event \event\models\Event
 */
?>

<?=CHtml::beginForm($this->createUrl('/oauth/main/dialog'))?>
  <legend>Здравствуйте, <a target="_blank" href="<?=Yii::app()->createUrl('/user/view/index', array('runetId' => $user->RunetId))?>"><?=$user->getFullName()?></a></legend>
  <p>Сайт <?=$event->Title?> запрашивает доступ к&nbsp;вашему аккаунту для использования данных профиля в&nbsp;целях авторизации:</p>
  <p id="cancel_warning" class="text-error" style="display: none;">Регистрация на сайте <?=$event->Title?> осуществлятся через сервис RUNET-ID и необходимо разрешение на получение данных вашего профиля. Нажмите еще раз "Отмена", для отказа в предоставлении доступа.</p>
  <br>
  <div class="tx-c">
    <button id="btn_cancel" class="btn">Отмена</button>
    &nbsp;
    <button type="submit" class="btn btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Разрешить</button>
  </div>
<?=CHtml::endForm()?>