<div class="content">

  <form id="recovery" action="" method="post">
    <div class="vacancies add-vacancy">
      <!-- <div class="field_filter">
       <h3>Фильтр вакансий</h3>
     </div> -->

      <h2>Восстановление пароля</h2>

      <p>Введите новый пароль к своему профайлу. Ваш персональный rocID: <?=$this->RocId;?>.</p>

      <div class="cfldset">

        <label for="password">Новый пароль</label>
        <p><input id="password" name="data[password]" type="password" autocomplete="off" value="<?=htmlspecialchars($this->Data['password']);?>"></p>

        <label for="password2">Пароль еще раз</label>
        <p><input id="password2" name="data[password2]" type="password" autocomplete="off" value="<?=htmlspecialchars($this->Data['password2']);?>"></p>

        <!-- end cfldset -->
      </div>


      <div class="response">
        <a href="" onclick="$('#recovery')[0].submit(); return false;">Сменить пароль</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>
 
