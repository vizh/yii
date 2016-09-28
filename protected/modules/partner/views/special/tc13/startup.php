<?php
/**
 * @var string $result
 * @var \pay\models\Product[] $products
 */

$data = ['' => 'Выберите тип участия'];
foreach ($products as $product)
{
  $data[$product->Id] = $product->Title;
}
?>
<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Генерация пригласительных</h2>
  </div>
</div>

<?if(!empty($result)):?>
  <div class="row">
    <div class="span10">
      <div class="alert alert-success">
        <br>
        <code><?=$result?></code>
        <br>&nbsp;
      </div>
    </div>
  </div>
<?endif?>

<div class="row">
  <div class="span10 offset1">
    <?=CHtml::beginForm()?>

    <div class="control-group">
      <?=CHtml::label('Тип товара:', 'product')?>
      <?=CHtml::dropDownList('product', 0, $data)?>
    </div>

    <div class="control-group">
      <?=CHtml::label('Количество:', 'count')?>
      <?=CHtml::textField('count', '', ['placeholder' => 1])?>
    </div>

    <div class="control-group">
      <button class="btn btn-success btn-large" type="submit"><i class="icon-ok icon-white"></i> Генерировать</button>
    </div>


    <?=CHtml::endForm()?>
  </div>
</div>