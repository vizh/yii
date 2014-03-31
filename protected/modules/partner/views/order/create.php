<?php
/**
 * @var OrderController $this
 * @var int $payerRunetId
 * @var \pay\models\Product[] $products
 * @var \pay\models\forms\Juridical $form
 */
?>
<?=\CHtml::beginForm()?>
  <div id="step1" class="row">
    <div class="span12">
      <? $this->renderPartial('create/step1', ['payerRunetId' => $payerRunetId]) ?>
    </div>
  </div>

  <div id="step2" class="row hide">
    <div class="span12">
      <? $this->renderPartial('create/step2', ['products' => $products]) ?>
    </div>
  </div>

  <div id="step3" class="row hide">
    <div class="span12">
      <? $this->renderPartial('create/step3', ['form' => $form]) ?>
    </div>
  </div>

<?=\CHtml::endForm()?>