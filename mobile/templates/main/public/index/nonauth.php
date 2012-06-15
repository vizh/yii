<div data-role="content" data-theme="f">  
  <div class="start-logo"><img src="/images/mlogobig.png" alt=""></div>
  <form action="/" method="post" >
    
    <div data-role="fieldcontain">
      <input type="hidden" name="formid" value="loginform">
      <label for="rocid">почта или rocID</label>
      <input type="text" name="rocid" id="rocid" value="" data-theme="f" autocomplete="off" />
      
      <label for="password">пароль</label>
      <input type="text" name="password" id="password" value="" data-theme="f" autocomplete="off" />

      <fieldset data-role="controlgroup">
        <?php $num = rand(0, 10000); ?>
        <input type="checkbox" name="save" id="save<?php echo $num; ?>" />
        <label for="save<?php echo $num; ?>">запомнить информацию</label>
      </fieldset>

      <button type="submit" data-theme="g">авторизоваться</button>
      <a href="/main/recovery/" data-role="button">Получить временный пароль</a>
    </div>

  </form> 

</div>


