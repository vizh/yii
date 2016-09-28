<?php
/**
 * @var $question \competence\models\tests\runet2013\D5
 */
?>
<h3>Пожалуйста, прочитайте полностью позитивный и негативный сценарии развития сегмента <strong><?=$question->getSelectSegmentTitle()?></strong> в России до 2018 г. оцените вероятность реализации каждого прогноза в %.</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<h4>Позитивный прогноз</h4>
<div><?=$question->getPositiveForecast()?></div>
<div class="form-inline m-top_10">
  Вероятность реализации <?=\CHtml::activeTextField($question, 'positive_value', ['class' => 'input-mini'])?> %
</div>

<h4 class="m-top_40">Негативный прогноз</h4>
<div><?=$question->getNegativeForecast()?></div>
<div class="form-inline m-top_10">
  Вероятность реализации <?=\CHtml::activeTextField($question, 'negative_value', ['class' => 'input-mini'])?> %
</div>