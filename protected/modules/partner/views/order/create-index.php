<form method="post" class="">
  <div class="row">
    <div class="span12 indent-bottom2">
      <h2>Выставление счета</h2>
    </div>
  </div>
  <div class="row">
    <div class="span12 indent-bottom1">
      <?php echo CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
      <label>Фамилия и Имя или rocID пользователя, на которого будет выставлен счет</label>
      <?php $this->widget('\partner\widgets\UserAutocompleteInput', array('form' => $form, 'field' => 'PayerRocId'));?>
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