<?php
/**
 * @var \pay\models\forms\Juridical $form
 */
?>
<div class="row">
  <div class="span12 indent-bottom2">
    <h2>Шаг 3. Реквизиты</h2>
  </div>
</div>
<div class="row">
  <div class="span12 indent-bottom1">
    <? if ($form->hasErrors()): ?>
      <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
    <? endif ?>
    <?$this->renderPartial('_juridical-data', ['form' => $form])?>
  </div>
</div>
<div class="row">
  <div class="span12">
    <?=\CHtml::link('Отмена', '#', ['class' => 'btn cancel'])?>
    <?=\CHtml::submitButton('Выставить', ['name' => 'complete', 'class' => 'btn btn-success'])?>
  </div>
</div>