<?php
/**
 * @var \event\widgets\FastRegistration $this
 * @var bool $isParticipant
 * @var \event\models\Role $role
 * @var \event\models\Event $event
 */
?>
<div class="event-registration registration fast">

  <?if (isset($this->FastRegistrationText)):?>
    <?=$this->FastRegistrationText;?>
  <?else:?>
    <p><?=\Yii::t('app', 'Вы можете бесплатно зарегистрироваться на мероприятие');?> &laquo;<?=$event->Title;?>&raquo; <?=\Yii::t('app', 'со статусом');?> &laquo;<?=$role->Title;?>&raquo;.<br/></p>
    <?if ($event->getContactAddress() !== null):?>
      <p><?=\Yii::t('app', 'Нажимая кнопку «Зарегистрироваться» вы подтверждаете свое участие в мероприятие');?> <?$this->widget('event\widgets\Date', ['html' => false, 'event' => $event]);?>, <?=\Yii::t('app', 'которое состоится по адресу');?> <?=$event->getContactAddress();?></p>
    <?endif;?>
  <?endif;?>



  <?if (!$isParticipant):?>
    <?=\CHtml::form('','POST');?>
      <?= \CHtml::hiddenField(\Yii::app()->request->csrfTokenName, \Yii::app()->request->getCsrfToken()); ?>
      <?if (\Yii::app()->user->isGuest):?>
        <a href="#" class="btn btn-info" id="PromoLogin"><?=\Yii::t('app', 'Авторизоваться / Зарегистрироваться');?></a>
      <?else:?>
      <?if (isset($this->FastRegistrationButtonText)):?>
        <?=\CHtml::submitButton($this->FastRegistrationButtonText, ['class' => !$event->FullWidth ? 'btn btn-info' : 'btn btn-large btn-success']);?>
      <?else:?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => !$event->FullWidth ? 'btn btn-info' : 'btn btn-large btn-success']);?>
      <?endif;?>
      <?endif;?>
    <?=\CHtml::endForm();?>
  <?else:?>
    <span class="text-success"><?=\Yii::t('app', 'Вы зарегистрированы на мероприятие.');?></span>
  <? endif; ?>
</div>

