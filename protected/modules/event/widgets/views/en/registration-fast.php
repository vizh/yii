<?php
/**
 * @var $this \event\widgets\About
 * @var $isParticipant bool
 */
?>
<div class="registration fast">
  <p>You can register for free at the event «<?=$event->Title;?>» with the status of «<?=$role->Title;?>».</p>

  <p>By clicking sign up, you confirm your participation in the activity <?$this->widget('event\widgets\Date', ['html' => false, 'event' => $event]);?><?if ($event->getContactAddress() !== null):?>, which will be held at <?=$event->getContactAddress();?><?endif;?></p>

  <?if (!$isParticipant):?>
    <?=\CHtml::form('','POST');?>
    <?if (\Yii::app()->user->isGuest):?>
      <a href="#" class="btn btn-info" id="PromoLogin"><?=\Yii::t('app', 'Авторизоваться / Зарегистрироваться');?></a>
    <?else:?>
      <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), array('class' => 'btn btn-info'));?>
    <?endif;?>
    <?=\CHtml::endForm();?>
  <?else:?>
    <span class="text-success"><?=\Yii::t('app', 'Вы зарегистрированы на мероприятие.');?></span>
  <? endif; ?>
</div>

