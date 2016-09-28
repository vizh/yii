<?php
/**
 * @var $question \competence\models\tests\runet2013\A5
 */
?>
<style type="text/css">
  .form-horizontal>.control-group>.control-label {
    width: 380px;
  }
  .form-horizontal>.control-group>.controls {
    margin-left: 400px;
  }
</style>

<h3>Сколько полных лет вы работаете...</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<div class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Я работаю в указанной должности уже</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'position', ['class' => 'input-mini'])?> лет.
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Я работаю в указанной компании уже</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'company', ['class' => 'input-mini'])?> лет.
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Я работаю в индустрии, связанной с интернетом уже</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'industry', ['class' => 'input-mini'])?> лет.
    </div>
  </div>
</div>
