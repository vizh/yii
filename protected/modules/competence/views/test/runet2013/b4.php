<?php
/**
 * @var $question \competence\models\tests\runet2013\B4_base
 */
?>
<h3>Готовы ли вы предоставить детальную информацию о своей компании ны рынке <strong><?=$question->getMarketTitle()?></strong> или же согласны дать оценку только по всему рынку?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<label class="radio">
  <?=\CHtml::activeRadioButton($question, 'value', ['uncheckValue' => null, 'value' => \competence\models\tests\runet2013\B4_base::MARKETANDCOMPANY_VALUE])?>
  Готов(-а) ответить на вопросы и о своей компании, и о рынке в целом
</label>
<label class="radio">
  <?=\CHtml::activeRadioButton($question, 'value', ['uncheckValue' => null, 'value' => \competence\models\tests\runet2013\B4_base::MARKET_VALUE])?>
  Готов(-а) ответить на вопросы только о рынке в целом
</label>
