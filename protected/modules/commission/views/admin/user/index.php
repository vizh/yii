<?=\CHtml::form('','POST',array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-success'));?>
</div>
<div class="well">
  <div class="row-fluid">
    <?if (\Yii::app()->user->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success');?></div>
    <?endif;?>
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
      
    <div class="span8">
      <?foreach($form->Users as $i => $formUser):?>
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'RunetId', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'Users[]');?>
          </div>
        </div>
      <?endforeach;?>
    </div>
  </div>
</div>
<?=\CHtml::endForm();?>