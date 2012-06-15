<h1 class="event"><?=$this->Name?> <br> <span class="count">ЗАРЕГИСТРИРОВАННЫЕ УЧАСТНИКИ МЕРОПРИЯТИЯ (<?=$this->Count;?> <?=Yii::t('app', 'человек|человека|человек|человека', $this->Count);?>)</span></h1>
 
<div id="large-left">
  <div id="search_line">
    <form action="" method="get" accept-charset="utf-8">
      <input type="text" id="search_box" value="<?=$this->Query;?>" name="q">
      <input type="submit" id="search_button" value="Найти">
      <p><a href="/events/<?=$this->IdName?>/">Вернуться на страницу мероприятия</a></p>
    </form>
  </div>

  <?=$this->Users;?>

  <?=$this->Paginator;?>
</div>


<div class="sidebar sidebarrapple">

  <?php echo $this->Banner;?>
</div>