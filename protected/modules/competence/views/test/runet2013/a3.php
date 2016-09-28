<?php
/**
 * @var $question \competence\models\tests\runet2013\A3
 */
?>
<h3>Ваше основное место работы (полное название компании/организации)</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<ul class="unstyled">
  <li>
    <?=CHtml::activeTextField($question, 'value', ['class' => 'input-block-level'])?>
  </li>
</ul>

