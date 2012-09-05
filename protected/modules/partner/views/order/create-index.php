<?php if ( isset ($this->Error)):?>
    <div class="alert alert-error"><?php echo $this->Error;?></div>
<?php endif;?>

<form method="POST" class="">
  <div class="row">
      <div class="span12 indent-bottom2">
          <h2>Формирование заказа</h2>
      </div>
  </div>
  <div class="row">
      <div class="span12 indent-bottom1">
          <label>Фамилия и Имя или rocID пользователя, на которого будет выставлен счет</label>
          <input name="CreateOrder[Payer][RocId]" value="" />
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