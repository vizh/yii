<div class="content">

  <form id="register" action="" method="post">
    <div class="vacancies add-vacancy">

      <h2>Завершить регистрацию</h2>

      <div class="cfldset">
        <label>Фамилия:</label>
        <p><input name="data[LastName]" type="text" autocomplete="off" value="<?=$this->LastName;?>" placeholder="Введите фамилию"></p>

        <label>Имя:</label>
        <p><input name="data[FirstName]" type="text" autocomplete="off" value="<?=$this->FirstName;?>" placeholder="Введите имя"></p>

        <label>Контактный email:</label>
        <p><input name="data[Email]" type="text" autocomplete="off" value="<?=$this->Email;?>" placeholder="Введите контактный email"></p>


        <!-- end cfldset -->
      </div>

      <div class="response">
        <a href="" onclick="$('#register')[0].submit(); return false;">Зарегистрироваться</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>