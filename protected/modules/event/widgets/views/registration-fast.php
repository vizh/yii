<div class="registration fast">
  <p>
    <?=\Yii::t('app', 'Бесплатная регистрация на мероприятие');?> &laquo;<?=$event->Title;?>&raquo; <?=\Yii::t('app', 'со статусом');?> &laquo;<?=$role->Title;?>&raquo;.
    <?if (!empty($additionalDescription)):?>
      <br/><?=$additionalDescription;?>
    <?endif;?>
  </p>
  <?if (!$isParticipant):?>
    <?=\CHtml::form('','POST');?>
      <?if (\Yii::app()->user->isGuest):?>
        <p class="text-error"><?=\Yii::t('app', 'Для регистрации на мероприятии, пожалуйста, авторизуйтесь.');?></p>
      <?endif;?>
      <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), array('class' => 'btn btn-info', 'disabled' => \Yii::app()->user->isGuest ? true : false));?>
    <?=\CHtml::endForm();?>
  <?else:?>
    <span class="text-success"><?=\Yii::t('app', 'Вы зарегистрированы на мероприятии.');?></span>
  <? endif; ?>
</div>

