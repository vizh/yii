<div class="content">
  <form id="auth" action="" method="post">
    <div class="vacancies add-vacancy">
      <h2>Здравствуйте, <?=$this->User->FirstName;?> <?=$this->User->LastName;?></h2>

      <p>В данный момент вы не авторизованы в системе ROCID. Для авторизации введите пароль к своему аккаунту.</p>

      <p>Мы предполагаем, что ваш rocID: <strong><?=$this->User->RocId;?></strong></p>


      <div class="cfldset">
        <label>Пароль:</label>
        <p><input name="password" type="password" value=""></p>
        <!-- end cfldset -->
      </div>

      <div class="response">
        <a href="" onclick="$('#auth')[0].submit(); return false;">Отправить</a>
      </div>
    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>
</div>