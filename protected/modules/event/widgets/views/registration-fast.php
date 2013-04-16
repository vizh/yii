<?if (!$isParticipant):?>
<?=\CHtml::form('','POST', array('class' => 'registration fast'));?>
  <?if (\Yii::app()->user->isGuest):?>
    <p class="text-error"><?=\Yii::t('app', 'Для регистрации на мероприятии, пожалуйста, авторизуйтесь');?></p>
  <?endif;?>
  <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), array('class' => 'btn btn-large btn-info', 'disabled' => \Yii::app()->user->isGuest ? true : false));?>
<?=\CHtml::endForm();?>
<?else:?>
  <div class="registration fast">
    <span class="text-success"><?=\Yii::t('app', 'Вы уже зарегистрированы на мероприятии.');?></span>
  </div>
<? endif; ?>

