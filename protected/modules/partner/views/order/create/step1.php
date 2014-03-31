<?php
/**
 * @var int $payerRunetId
 */
?>
<div class="row">
  <div class="span12 indent-bottom2">
    <h2>Шаг 1. Получатель счета</h2>
  </div>
</div>
<div class="row">
  <div class="span12 indent-bottom1">
    <label>Фамилия и Имя или RUNET-ID пользователя, на которого будет выставлен счет</label>
    <? $this->widget('\partner\widgets\UserAutocompleteInput', [
      'field' => 'payerRunetId',
      'value' => $payerRunetId
    ]); ?>
    <p class="help-block">
      <strong>Заметка:</strong> Просто начните набирать фамилию и имя или RUNET-ID пользователя. Здесь автоматически будут отображаться результаты поиска.
    </p>
  </div>
</div>
<div class="row buttons">
  <div class="span12">
    <?=\CHtml::link('Отмена', '#', ['class' => 'btn cancel'])?>
    <?=\CHtml::link('Продолжить', '#', ['name' => 'step2', 'class' => 'btn btn-primary'])?>
  </div>
</div>