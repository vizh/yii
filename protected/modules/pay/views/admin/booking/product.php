<?
/**
 * @var \pay\models\Product $product
 * @var \pay\models\forms\admin\BookingProduct $form
 */?>

<div class="btn-toolbar">
  <?if (!empty($backUrl)):?>
    <a href="<?=$backUrl;?>" class="btn">← <?=\Yii::t('app','Назад');?></a>
  <?endif;?>
</div>
<div class="well">
  <?if (\Yii::app()->getUser()->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
  <?endif;?>
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error>"', '</div>');?>
  <?=\CHtml::form('','POST',['class' => 'form-horizontal']);?>
    <?foreach (array_keys($form->Attributes) as $name):?>
      <div class="control-group">
        <?=\CHtml::activeLabel($form,$name, ['class' => 'control-label']);?>
        <div class="controls">
          <?=\CHtml::activeTextField($form,'Attributes['.$name.']');?>
        </div>
      </div>
    <?endforeach;?>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
      </div>
    </div>
  <?=\CHtml::endForm();?>
</div>