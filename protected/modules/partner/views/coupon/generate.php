<?php
/**
 * @var $products \pay\models\Product[]
 * @var $form \partner\models\forms\coupon\Generate
 * @var $result string
 */
$productDropDown = array();
$productDropDown[0] = 'На все типы продуктов';
foreach ($products as $product)
{
  $productDropDown[$product->Id] = $product->Title;
}
?>

<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Генерация промо-кодов</h2>
  </div>
</div>

<?if ($form->hasErrors()):?>
  <div class="row">
    <div class="span8 offset2">
      <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    </div>
  </div>
<?endif;?>

<?if ($result !== false):?>
  <div class="row">
    <div class="span8 offset2">
      <div class="alert alert-success">
        <p><?=$result;?></p>
      </div>
    </div>
  </div>
<?endif;?>

<div class="row">
  <div class="span10 offset1">
    <?=CHtml::beginForm();?>

    <div class="control-group <?=$form->hasErrors('count') ? 'error' : '';?>">
      <?=CHtml::activeLabel($form, 'count');?>
      <?=CHtml::activeTextField($form, 'count');?>
    </div>
    <div class="control-group <?=$form->hasErrors('discount') ? 'error' : '';?>">
      <?=CHtml::activeLabel($form, 'discount');?>
      <?=CHtml::activeTextField($form, 'discount');?>
    </div>
    <div class="control-group <?=$form->hasErrors('productId') ? 'error' : '';?>">
      <?=CHtml::activeLabel($form, 'productId');?>
      <?=CHtml::activeDropDownList($form, 'productId', $productDropDown);?>
    </div>

    <div class="control-group">
    <button class="btn btn-success btn-large" type="submit"><i class="icon-ok icon-white"></i> Генерировать</button>
    </div>

    <?=CHtml::endForm();?>
  </div>
</div>