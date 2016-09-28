<?php
/**
 * @var $question \competence\models\tests\runet2013\B1
 */
?>
<h3>По какому из сегментов интернет-индустрии вы хотели бы выступить в качестве эксперта?</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<?foreach($question->getOptions() as $key => $option):?>
<div class="form-inline">
  <label class="radio">
    <?=CHtml::activeRadioButton($question, 'value', ['value' => $key, 'uncheckValue' => null])?>
    <?=$option[0]?>
    <p class="muted m-top_5"><?=$option[1]?></p>
  </label>
</div>
<?endforeach?>


