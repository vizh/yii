<?php
/**
 * @var \pay\models\Product[] $products
 */
?>
<div class="row">
  <div class="span12 indent-bottom2">
    <h2>Шаг 2. Состав счета</h2>
  </div>
</div>
<div class="row">
  <div class="span12 indent-bottom1">
    <?$this->renderPartial('_orders-table', ['products' => $products])?>
  </div>
</div>
<div class="row buttons">
  <div class="span12">
    <?=\CHtml::link('Отмена', '#', ['class' => 'btn cancel'])?>
    <?=\CHtml::link('Продолжить', '#', ['name' => 'step3', 'class' => 'btn btn-primary'])?>
  </div>
</div>