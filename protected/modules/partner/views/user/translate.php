<div class="row">
  <div class="span12 m-bottom_30">
    <h2 class="m-bottom_5"><?=\Yii::t('app', 'Редактирование персональных данных участника');?></h2>
    <a href="<?=$this->createUrl('/partner/user/edit', array('runetId' => $user->RunetId));?>" class="small">&larr; <?=\Yii::t('app', 'Вернуться к редактированию участника');?></a>
  </div>
 
  <?php
    $errors = array();
    foreach ($locales as $locale):
      $errors = array_merge($errors, $forms->$locale->getErrors());
    endforeach;
    
    if (!empty($errors)):
  ?>
  <div class="span12 m-bottom_10">
    <div class="alert alert-error">
      <?foreach($errors as $error):?>
        <?=$error[0];?><br/>
      <?endforeach;?>
    </div>
  </div>
  <?elseif (\Yii::app()->user->hasFlash('success')):?>
  <div class="span12">
    <div class="alert alert-success">
      <?=\Yii::app()->user->getFlash('success');?>
    </div>
  </div>
  <?endif;?>
  
  
  
  <?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>
  <div class="span12">
    <?foreach (array_keys($forms->ru->getAttributes()) as $attribute):?>
      <?if ($attribute == 'Company' && $user->getEmploymentPrimary() == null) 
        continue;
      ?>
      <div class="control-group">
        <?=\CHtml::activeLabel($forms->ru, $attribute, array('class' => 'control-label'));?>
        <div class="controls">
          <?foreach ($locales as $locale):?>
            <div class="input-prepend">
              <span class="add-on"><?=$locale;?></span>
              <?=\CHtml::activeTextField($forms->$locale, $attribute, array('class' => 'input-medium', 'name' => 'Translate['.$locale.']['.$attribute.']'));?>
            </div>
          <?endforeach;?>
        </div>
      </div>
    <?endforeach;?>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn'));?>
      </div>
    </div>
  </div>
  <?=\CHTml::endForm();?>
</div>