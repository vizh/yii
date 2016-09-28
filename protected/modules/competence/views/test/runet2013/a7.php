<?php
/**
 * @var $question \competence\models\tests\runet2013\A7
 */
?>
<h3>Есть ли у вас...</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<div class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Ученая степень</label>
    <div class="controls">
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'academic_degree', ['value' => 'нет', 'uncheckValue' => null, 'data-group' => 'academic_degree'])?>
        нет
      </label>
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'academic_degree', ['value' => 'да', 'uncheckValue' => null, 'data-group' => 'academic_degree', 'data-target' => '[name*="academic_degree_value"]'])?>
        да
      </label>
      <?=CHtml::activeTextField($question, 'academic_degree_value', ['placeholder' => 'какая?', 'class' => 'input-xlarge', 'data-group' => 'academic_degree'])?>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label">Ученое звание</label>
    <div class="controls">
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'academic_title', ['value' => 'нет', 'uncheckValue' => null, 'data-group' => 'academic_title'])?>
        нет
      </label>
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'academic_title', ['value' => 'да', 'uncheckValue' => null, 'data-group' => 'academic_title', 'data-target' => '[name*="academic_title_value"]'])?>
        да
      </label>
      <?=CHtml::activeTextField($question, 'academic_title_value', ['placeholder' => 'какое?', 'class' => 'input-xlarge', 'data-group' => 'academic_title'])?>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label">Степерь MBA</label>
    <div class="controls">
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'MBA_degree', ['value' => 'нет', 'uncheckValue' => null, 'data-group' => 'MBA_degree'])?>
        нет
      </label>
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'MBA_degree', ['value' => 'да', 'uncheckValue' => null, 'data-group' => 'MBA_degree', 'data-target' => '[name*="MBA_degree"]'])?>
        да
      </label>
      <?=CHtml::activeTextField($question, 'MBA_degree_value', ['placeholder' => 'в каком учебном заведении получена?', 'class' => 'input-xlarge', 'data-group' => 'MBA_degree'])?>
    </div>
  </div>
</div>
