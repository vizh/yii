<h2 class="m-bottom_30"><?=\Yii::t('app','Редактирование секции');?></h2>
<div class="row">
<div class="span8">
  <?if (\Yii::app()->user->hasFlash('success')):?>
  <div class="alert alert-success">
    <?=\Yii::app()->user->getFlash('success');?>
  </div>
  <?endif;?>
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error">','</div>');?>
  
  <?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Title');?>
      </div>
    </div>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Info', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextArea($form, 'Info', array('class' => 'input-block-level'));?>
      </div>
    </div>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Date', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'Date', $form->getDateList($event), array('class' => 'input-medium'));?>
        <?=\CHtml::activeTextField($form, 'TimeStart', array('class' => 'input-mini', 'placeholder' => \Yii::t('app','С')));?> &ndash;
        <?=\CHtml::activeTextField($form, 'TimeEnd', array('class' => 'input-mini', 'placeholder' => \Yii::t('app','До')));?>
      </div>
    </div>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Hall', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'Hall', $form->getHallList($event), array('multiple' => true));?>
        <?=\CHtml::activeTextField($form, 'HallNew', array('class' => 'm-top_10'));?>
      </div>
    </div>
    
    <?foreach($form->getAttributeList($event, $section) as $attrName => $attrValue):?>
    <div class="control-group">
      <label class="control-label"><?=$attrName;?></label>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Attribute['.$attrName.']', array('value' => $attrValue));?>
      </div>
    </div>
    <?endforeach;?>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'AttributeNew', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'AttributeNew[Name]', array('class' => 'input-medium', 'placeholder' => \Yii::t('app','Название')));?>
        <?=\CHtml::activeTextField($form, 'AttributeNew[Value]', array('class' => 'input-medium', 'placeholder' => \Yii::t('app','Описание')));?>
      </div>
    </div>
  
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Type', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'Type', $form->getTypeList());?>
      </div>
    </div>
    
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Обновить'), array('class' => 'btn btn-info'));?>
      </div>
    </div>
  <?=\CHtml::endForm();?>
</div>
</div>
