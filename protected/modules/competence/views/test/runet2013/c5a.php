<?php
/**
 * @var $question \competence\models\tests\runet2013\C5_base
 */
?>
<h3>Сколько всего человек занято на российском рынке <strong><?=$question->getMarketTitle()?></strong>, включая штатных и внештатных работников?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <?=\CHtml::activeTextField($question, 'value', ['class' => 'input-mini'])?> человек
</div>
