<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Редактирование участника</h2>
  </div>

  <div class="span12">
    <?if (!empty($this->action->error)):?>
    <div class="alert alert-error">
      <button data-dismiss="alert" class="close">×</button>
      <strong>Ошибка!</strong> <?=$this->action->error;?>
    </div>
    <?endif;?>
  </div>


  <form action="" method="post">
    <div class="span12">
      <div class="control-group">
        <label for="NameOrRocid" class="control-label"><strong>Фамилия и Имя</strong> или <strong>rocID</strong></label>
        <div class="controls">
          <input type="text" id="NameOrRocid" name="NameOrRocid" class="input-xxlarge" placeholder="Введите ФИО" value="<?=isset($nameOrRocid) ? $nameOrRocid : '';?>">
          <p class="help-inline"><input type="hidden" name="rocId" id="RocId" value="<?=isset($rocId) ? $rocId : '';?>"><span id="span_rocid" style="display: none;" class="label label-success"></span></p>
          <p class="help-block">
            <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
          </p>
        </div>
      </div>
    </div>

    <div class="span12 indent-top3">
      <input class="btn btn-primary" type="submit" value="Продолжить">
    </div>
  </form>

</div>