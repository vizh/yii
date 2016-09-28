<?php
/**
 * @var $question \competence\models\tests\runet2013\A2
 */
?>
<h3>Дата вашего рождения</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<ul class="unstyled">
  <li>
    <?=CHtml::activeTextField($question, 'value', ['class' => 'input-block-level'])?>
  </li>
</ul>
