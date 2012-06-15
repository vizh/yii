<div class="ads">
  <?php echo $this->Banner;?>
</div>


<div class="search">
  <div id="search_line">
    <form action="" method="get" accept-charset="utf-8">
      <input type="text" id="search_box" value="<?=$this->Query;?>" name="q">
      <input type="submit" id="search_button" value="Найти">
      <p>Поиск работает по новостям, компаниям и зарегистрированным пользователям</p>
    </form>
  </div>

  <?php echo $this->AfterInput;?>

  <div class="results">
    <ul>
      <?php echo $this->Result;?>
    </ul>
  </div>
  <?=$this->Paginator;?>
</div>