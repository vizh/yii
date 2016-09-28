<?php
/**
 * @var $question \competence\models\tests\runet2013\A6
 */
?>
<style type="text/css">
  .form-horizontal>.control-group>.control-label {
    width: 300px;
  }
  .form-horizontal>.control-group>.controls {
    margin-left: 320px;
  }
</style>

<h3>Ваша контактная информация</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<div class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Рабочий телефон </label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'work_phone')?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Мобильный телефон</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'mobile_phone')?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Рабочий адрес электронной почты</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'work_email')?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Основной адрес электронной почты</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'main_email')?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Дополнительный адрес электронной почты</label>
    <div class="controls">
      <?=CHtml::activeTextField($question, 'additional_email')?>
    </div>
  </div>
</div>
