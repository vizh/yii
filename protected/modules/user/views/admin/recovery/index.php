<?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'))?>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Изменение пароля'), array('class' => 'btn'))?>
</div>
<div class="well">
  <div class="row-fluid">
    <div class="span12">
      <?if(\Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success')?></div>
      <?elseif (\Yii::app()->user->hasFlash('error')):?>
        <div class="alert alert-error"><?=\Yii::app()->user->getFlash('error')?></div>
      <?endif?>
      <div class="control-group">
        <label class="control-label">RUNET&ndash;ID</label>
        <div class="controls">
          <?=\CHtml::textField('RunetId', '')?>
        </div>
      </div>
    </div>
  </div>
</div>
<?=\CHtml::endForm()?>