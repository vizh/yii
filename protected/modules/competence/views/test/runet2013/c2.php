<?php
/**
 * @var $question \competence\models\tests\runet2013\C2_base
 */
?>
<h3>Какова общая динамика оборота компаний на российском рынке <strong><?=$question->getMarketTitle()?></strong> по итогам 2012 г. по сравнению с 2011 г.?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline m-bottom_10">
  <label class="radio"><?=\CHtml::activeRadioButton($question, 'value', ['value' => 'увеличится', 'uncheckValue' => null, 'data-group' => 'c2', 'data-target' => '[name*="decrease_value"]'])?>
  Увеличился на</label> <?=\CHtml::activeTextField($question, 'decrease_value', ['class' => 'input-mini', 'data-group' => 'c2'])?> %
</div>
<label class="radio">
  <?=\CHtml::activeRadioButton($question, 'value', ['value' => 'останется без изменений', 'uncheckValue' => null, 'data-group' => 'c2'])?> Остался без изменений
</label>
<div class="form-inline m-top_10">
  <label class="radio"><?=\CHtml::activeRadioButton($question, 'value', ['value' => 'уменьшится', 'uncheckValue' => null, 'data-group' => 'c2', 'data-target' => '[name*="increase_value"]'])?>
  Уменьшился на</label> <?=\CHtml::activeTextField($question, 'increase_value', ['class' => 'input-mini', 'data-group' => 'c2'])?> %
</div>
