<?
/**
 * @var OrderController $this
 * @var \pay\models\Order $order
 * @var \pay\models\forms\Juridical $form
 * @var \pay\models\Product[] $products
 */
  $this->pageTitle = \Yii::t('app', 'Редактирование счета');
?>

<h2 class="indent-bottom3"><?=\Yii::t('app', 'Редактирование счета');?> №<?=$order->Id;?></h2>
<? if (\Yii::app()->getUser()->hasFlash('success')): ?>
  <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
<? endif ?>
<?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>

<?=\CHtml::beginForm('', 'POST', ['class' => 'form-horizontal']);?>
  <?$this->renderPartial('_juridical-data', ['form' => $form])?>
  <div class="control-group">
    <div class="controls">
      <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
    </div>
  </div>
<?=\CHtml::endForm();?>

<div class="m-top_40">
<?=\CHtml::beginForm()?>
  <?$this->renderPartial('_orders-table', ['products' => $products])?>
<?=\CHtml::endForm()?>
</div>