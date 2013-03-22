<?=\CHtml::form('', 'POST');?>
  <fieldset>
    <legend>Восстановление пароля</legend>
    <p>Вы можете получить ваш текущий пароль по электронной почте на адрес, указанный при регистрации RUNET-ID:</p>
    <div class="control-group">
      <?=\CHtml::activeTextField($form, 'Email', array('placeholder' => \Yii::t('app', 'Электронная почта'), 'class' => 'span4'));?>
    </div>
    
    <?if ($form->ShowCode):?>
    <div class="control-group">
      <?=\CHtml::activeTextField($form, 'Code', array('placeholder' => \Yii::t('app', 'Код'), 'class' => 'span4'));?>
    </div>
    <?endif;?>
    
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    
    <?if (\Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
      <?=\Yii::app()->user->getFlash('success');?>
    </div>
    <?endif;?>
    
    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Восстановить</button>
  </fieldset>
<?=\CHtml::endForm();?>