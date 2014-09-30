<?=\CHtml::form('', 'POST');?>
  <fieldset>
    <legend><?=Yii::t('app', 'Восстановление пароля');?></legend>
    <p><?=Yii::t('app', 'Вы можете получить ваш текущий пароль по электронной почте или на телефон, указанный при регистрации RUNET-ID:');?></p>
    <div class="control-group">
      <?=\CHtml::activeTextField($form, 'EmailOrPhone', ['placeholder' => $form->getAttributeLabel('EmailOrPhone'), 'class' => 'span4']);?>
    </div>
    
    <?if ($form->ShowCode):?>
        <div class="control-group">
          <?=\CHtml::activeTextField($form, 'Code', array('placeholder' => \Yii::t('app', 'Код'), 'class' => 'span4'));?>
        </div>
    <?else:?>
        <div class="control-group">
            <?$this->widget('CCaptcha')?>
            <?=\CHtml::activeTextField($form, 'Captcha', ['placeholder' => $form->getAttributeLabel('Captcha'), 'class' => 'span4'])?>
        </div>
    <?endif;?>
    
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    
    <?if (\Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success">
          <?=\Yii::app()->user->getFlash('success');?>
        </div>
    <?endif;?>
    
    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;<?=Yii::t('app', 'Восстановить');?></button>
  </fieldset>
<?=\CHtml::endForm();?>