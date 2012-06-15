<div class="content">

  <form id="recovery" action="" method="post">
    <div class="vacancies add-vacancy">
      <!-- <div class="field_filter">
       <h3>Фильтр вакансий</h3>
     </div> -->

      <h2>Восстановление пароля</h2>

      <div class="cfldset">
        <label for="email">Электронный адрес</label>
        <p><input id="email" name="email" type="text" autocomplete="off" value="<?=$this->Email;?>"></p>

        <!-- end cfldset -->
      </div>


      <div class="response">
        <a href="" onclick="$('#recovery')[0].submit(); return false;">Восстановить</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>
 
