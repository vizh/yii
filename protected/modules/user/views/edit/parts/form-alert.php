<?if($form->hasErrors() || \Yii::app()->user->hasFlash('success')):?>
<div class="form-alert">
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
  <?if(\Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success')?></div>
  <?endif?>
</div>
<?endif?>