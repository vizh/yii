<?=\CHtml::form('', 'POST', ['id'=>'authForm'])?>
  <fieldset>
    <legend><?=Yii::t('app', 'Восстановление пароля')?></legend>
    <?=\CHtml::errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
    <p><?=Yii::t('app', 'Вы можете получить ваш текущий пароль по электронной почте, указанной при регистрации RUNET-ID:')?></p>
    <div class="form-group">
      <?=\CHtml::activeTextField($form, 'EmailOrPhone', ['placeholder' => $form->getAttributeLabel('EmailOrPhone'), 'class' => 'form-control', 'autocomplete' => 'off'])?>
    </div>

    <?if($form->ShowCode):?>
        <div class="form-group">
          <?=\CHtml::activeTextField($form, 'Code', ['placeholder' => \Yii::t('app', 'Код'), 'class' => 'form-control', 'autocomplete' => 'off'])?>
        </div>
    <?elseif (false):?>
        <div class="form-group">
            <?$this->widget('CCaptcha')?>
            <?=\CHtml::activeTextField($form, 'Captcha', ['placeholder' => $form->getAttributeLabel('Captcha'), 'class' => 'form-control', 'autocomplete' => 'off'])?>
        </div>
    <?endif?>


    <?if(\Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success">
          <?=\Yii::app()->user->getFlash('success')?>
        </div>
    <?endif?>

    <button type="submit" class="btn btn-large btn-block btn-primary"><i class="icon-ok-sign icon-white"></i>&nbsp;<?=Yii::t('app', 'Восстановить')?></button>
  </fieldset>
<?=\CHtml::endForm()?>