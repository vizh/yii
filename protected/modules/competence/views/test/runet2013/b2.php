<?php
/**
 * @var $question \competence\models\tests\runet2013\B2
 */
?>
<h3>По какому (каким) из рынков вы хотели бы выступить в качестве эксперта?</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<?foreach($question->getOptions() as $key => $option):?>
<div class="form-inline">
  <label class="checkbox">
    <?=CHtml::activeCheckBox($question, 'value[]', ['value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value)])?>
    <?=$option[0]?>
  </label>
  <p class="muted"><?=$option[1]?></p>
</div>
<?endforeach?>


