<?php
/**
 * @var int $payerRunetId
 * @var string $error
 */
?>
<form method="get">
  <div class="row">
    <div class="span12 indent-bottom2">
      <h2>Выставление счета</h2>
    </div>
  </div>
  <div class="row">
    <div class="span12 indent-bottom1">
      <?if (!empty($error)):?>
          <div class="alert alert-error"><?=$error;?></div>
      <?endif;?>
      <label>Фамилия и Имя или rocID пользователя, на которого будет выставлен счет</label>
      <?$this->widget('\partner\widgets\UserAutocompleteInput', [
        'field' => 'payerRunetId',
        'value' => $payerRunetId
      ]);?>
      <p class="help-block">
        <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
      </p>
    </div>
  </div>
  <div class="row">
      <div class="span12">
          <input type="submit" value="Продолжить" class="btn btn-primary" />
      </div>
  </div>
</form>