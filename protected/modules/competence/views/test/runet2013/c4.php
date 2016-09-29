<?php
/**
 * @var $question \competence\models\tests\runet2013\C4_base
 */
?>
<h3>Назовите примерное количество компаний на российском рынке  <strong><?=$question->getMarketTitle()?></strong></h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <?=\CHtml::activeTextField($question, 'value', ['class' => 'input-mini'])?> компаний
</div>
