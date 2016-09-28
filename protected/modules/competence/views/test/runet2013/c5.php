<?php
/**
 * @var $question \competence\models\tests\runet2013\C5_base
 */
?>
<h3>Назовите примерный штат средней компании на российском рынке <strong><?=$question->getMarketTitle()?></strong>, включая специалистов, административный и технический персонал</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <?=\CHtml::activeTextField($question, 'value', ['class' => 'input-mini'])?> штатных единиц
</div>
