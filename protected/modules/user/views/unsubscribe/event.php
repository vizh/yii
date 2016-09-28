<?php
/**
 * @var \event\models\Event $event
 */
?>
<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Подписка успешно отменена')?></span>
    </div>
  </div>
</h2>
<div class="container m-bottom_50">
  <div class="row">
    <div class="span6 offset3">
      <p>Вы больше не будете получать рассылку, связанную с мероприятием «<?=$event->Title?>». <br/>Если это было сделано по ошибке, вы можете снова подписаться рассылку мероприятия в личном кабинете.</p>
    </div>
  </div>
</div>