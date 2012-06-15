<section class="main edit mask">
  <h2>Редактировать маску доступа</h2>
  <form id="form_editmask" action="" method="post">
    <input type="hidden" value="<?=$this->MaskId;?>" name="mask_id">
    <aside class="col-l">
      <input type="text" data-empty="<?=$this->words['news']['entertitle'];?>"
             class="title bordered" maxlength="250" name="data[title]"
             value="<?=htmlspecialchars($this->MaskTitle);?>" autocomplete="off">

      <h3>Права доступа:</h3>
      <ul class="rules">
        <?php echo $this->Rules;?>
      </ul>

    </aside>
    <aside class="col-r">
      <div class="pub bordered sidebar">
        <h4>Управление</h4>
        <a id="button_save" class="button positive save big"><span class="icon check"></span>Сохранить</a>
        <div class="cl"></div>
      </div>


    </aside>
  </form>
</section>
 
