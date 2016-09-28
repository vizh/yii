<?php
/**
 * @var $question \competence\models\tests\runet2013\B3_base
 */
?>
<h3>Является ли ваша компания участником рынка <strong><?=$question->getMarketTitle()?></strong></h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<label class="radio">
  <?=\CHtml::activeRadioButton($question, 'value', ['uncheckValue' => null, 'value' => 'да'])?>
  Да, является
</label>
<label class="radio">
  <?=\CHtml::activeRadioButton($question, 'value', ['uncheckValue' => null, 'value' => 'нет'])?>
  Нет, не является
</label>
