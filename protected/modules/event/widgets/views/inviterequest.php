<div class="registration">
  <h3><?=\Yii::t('app', 'Заявка на участие');?></h3>  
  
  <?if (\Yii::app()->getUser()->getIsGuest()):?>
    <p class="m-bottom_20"><?=\Yii::t('app', 'Участие в конференции бесплатное. Количество мест ограничено. Пожалуйста, заполните заявку, если мероприятие вам интересно. Для заполнения заявки  <a id="PromoLogin" href="">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID');?></p>
  <?elseif ($existsRequest):?>
    <div class="alert alert-success"><?=\Yii::t('app', 'Ваша заявка на участие в конференции принята к рассмотрению.');?></div>
  <?else:?>
    <p class="m-bottom_20"><?=\Yii::t('app', 'Участие в конференции бесплатное. Количество мест ограничено. Пожалуйста, заполните заявку, если мероприятие вам интересно. Результат рассмотрения заявки придет на вашу электронную почту: ');?>
      <strong><?=\Yii::app()->getUser()->getCurrentUser()->Email;?></strong>&nbsp;<a href="<?=\Yii::app()->createUrl('/user/edit/contacts');?>" style="font-size: 10px;">Редактировать.</a>
    </p>
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    <?=\CHtml::form('','post',['class' => 'form-horizontal']);?>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Phone', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Phone');?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Company', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Company');?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Position', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Position');?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Info', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextArea($form, 'Info');?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Отправить'), ['class' => 'btn']);?>
      </div>
    </div>
    <?=\CHtml::endForm();?>
  <?endif;?>
</div>