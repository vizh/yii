<section>
  <h3><?=$this->Error;?></h3>
  <form id="form_auth" action="" method="post">
    <fieldset>
      <div class="clearfix">
        <label for="rocid">rocID для авторизации:</label>
        <div class="input">
          <input type="text" name="rocid" id="rocid" class="span3">
        </div>
      </div>
      <div class="clearfix">
        <a class="button big" href="#" onclick="$('#form_auth')[0].submit(); return false;">Продолжить</a>
      </div>
    </fieldset>
  </form>
</section>
