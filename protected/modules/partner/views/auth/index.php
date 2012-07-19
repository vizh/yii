<div class="row login-box">
  <div class="offset4 span4">
    <form class="well" method="post" action="">
      <h2>Вход</h2>

      <div class="control-group">
        <label for="login" class="control-label">Логин</label>
        <div class="controls">
          <input type="text" id="login" class="span3" name="login" placeholder="Введите свой логин">
        </div>
      </div>

      <div class="control-group">
        <label for="password" class="control-label">Пароль</label>
        <div class="controls">
          <input type="password" id="password" class="span3" name="password" placeholder="Введите пароль">
          <?if ($this->error):?>
          <p class="help-block  <?=$this->error ? 'error' : '';?>">
            <span class="label label-important">Ошибка авторизации</span>
          </p>
          <?endif;?>
        </div>
      </div>

      <input type="submit" class="btn btn-primary" name="submit" value="Вход">

    </form>
  </div>
</div>