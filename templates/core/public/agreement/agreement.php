<div id="large-left" class="agreement">
  <h1>Пользовательское соглашение</h1>

  <div class="short">
    <?=$this->Text;?>
  </div>

  <form id="agreement_form" action="" method="post">
    <div class="cfldset">
      <input id="cancel" type="hidden" name="cancel" value="0">
      <p class="chbxs"><label><input id="no_site" type="checkbox" name="agree" value="1">Я принимаю пользовательское соглашение</label></p>

      <div class="response">
        <a href="" onclick="$('#agreement_form')[0].submit(); return false;">Принять</a>
        <a href="" onclick="$('#cancel').attr('value', 1); $('#agreement_form')[0].submit(); return false;">Отмена</a>
      </div>
    </div>
  </form>
</div>

<div class="sidebar sidebarcomp">
  <?php echo $this->Banner;?>
</div>