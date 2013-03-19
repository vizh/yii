<div class="container">
  <div class="content">
    <?=\CHtml::form('', 'POST',array('class' => 'form-horizontal'));?>
    <h4 class="m-bottom_40"><?=\Yii::t('app', 'Контактное лицо');?></h4>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'ContactName', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'ContactName');?>
      </div>
    </div>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'ContactPhone', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'ContactPhone');?>
      </div>
    </div>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'ContactEmail', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'ContactEmail');?>
      </div>
    </div>
    <?=\CHtml::endForm();?>
  </div>
</div>