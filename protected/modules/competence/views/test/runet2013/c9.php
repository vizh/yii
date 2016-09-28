<?php
/**
 * @var $question \competence\models\tests\runet2013\C9_base
 */
?>
<h3>Оцените, пожалуйста, оборот <u>вашей</u> компании на российском рынке <strong><?=$question->getMarketTitle()?></strong> в 2012 г.?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <?=\CHtml::activeTextField($question, 'value')?> млн. рублей
</div>
