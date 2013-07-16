<div class="registration">
  <h5 class="title"><?=Yii::t('app', 'Регистрация по приглашениям');?></h5>
  <p>Регистрация на конференцию осуществляется по приглашениям от организаторов мероприятия. Если у вас есть приглашение (промо-код), введите его для прохождения регистрации.</p>
  <p>Если у вас нет приглашения, но вы желаете посетить мероприятие, отправьте запрос на участие организаторам.</p>
  
  <?if (!\Yii::app()->getUser()->getIsGuest()):?>
    <?if (\Yii::app()->getUser()->hasFlash('widget.invite.success')):?>
      <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('widget.invite.success');?></div>
    <?endif;?>
    <div>
      <h5><?=Yii::t('app', 'Регистрация');?></h5>
      <?=\CHtml::errorSummary($formActivation, '<div class="alert alert-error">', '</div>');?>
      <?=\CHtml::beginForm('', 'POST', ['class' => 'form-inline']);?>
        <?=\CHtml::activeTextField($formActivation, 'FullName', ['class' => 'input-large', 'placeholder' => $formActivation->getAttributeLabel('FullName')]);?>
        <?=\CHtml::activeTextField($formActivation, 'Code', ['class' => 'input-medium', 'placeholder' => $formActivation->getAttributeLabel('Code')]);?>
        <?=\CHtml::activeHiddenField($formActivation, 'RunetId');?>
        <?=\CHtml::hiddenField('Form', get_class($formActivation));?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Активировать'), ['class' => 'btn']);?>
        <p class="help-block m-top_5">Начинайте вводить на клавиатуре имя владельца приглашения, чтобы выбрать его из списка.</p>
      <?=\CHtml::endForm();?>

      <h5><?=\Yii::t('app','Получить приглашение');?></h5>
      <?=\CHtml::errorSummary($formRequest, '<div class="alert alert-error">', '</div>');?>
      <?=\CHtml::beginForm('', 'POST', ['class' => 'form-inline']);?>
        <?=\CHtml::activeTextField($formRequest, 'FullName', ['class' => 'input-large', 'placeholder' => $formRequest->getAttributeLabel('FullName')]);?>
        <?=\CHtml::activeHiddenField($formRequest, 'RunetId');?>
        <?=\CHtml::hiddenField('Form', get_class($formRequest));?>
        <?=\CHtml::submitButton(\Yii::t('app', 'Отправить'), ['class' => 'btn']);?>
        <p class="help-block m-top_5">Начинайте вводить на клавиатуре имя владельца приглашения, чтобы выбрать его из списка.</p>
      <?=\CHtml::endForm();?>
    </div>
  <?else:?>
    <p class="text-error"><?=\Yii::t('app', 'Для запроса или активации приглашения, пожалуйста, <a href="" id="PromoLogin">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID.');?></p>
  <?endif;?>
</div>