<?php
/**
 * @var $question \competence\models\tests\runet2013\C1_base
 */
?>
<h3>Оцените, пожалуйста, общий оборот компаний на российском рынке <strong><?=$question->getMarketTitle()?></strong> в 2012 г.?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <?=\CHtml::activeTextField($question, 'value', ['class' => 'input-xlarge'])?> млн. рублей
</div>
