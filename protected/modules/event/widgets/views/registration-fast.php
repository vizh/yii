<div class="registration fast">
  <p>
    <p><?=\Yii::t('app', 'Вы можете бесплатно зарегистрироваться на мероприятие');?> &laquo;<?=$event->Title;?>&raquo; <?=\Yii::t('app', 'со статусом');?> &laquo;<?=$role->Title;?>&raquo;.<br/></p>
    <?if ($event->getContactAddress() !== null):?>
      <p><?=\Yii::t('app', 'Нажимая кнопку «Регистрация» вы подтверждаете свое участие в мероприятие');?> <?$this->widget('event\widgets\Date', ['html' => false, 'event' => $event]);?>, <?=\Yii::t('app', 'которое состоится по адресу');?> <?=$event->getContactAddress();?></p>
    <?endif;?>
  </p>
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

