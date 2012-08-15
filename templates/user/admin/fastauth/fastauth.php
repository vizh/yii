<section>
  <h3><?=$this->Error;?></h3>
  <div class="row">
    <div class="span6">
      <h4>Быстрая авторизация</h4>
      <p>Администратор имеет возможность авторизоваться из-под аккаунта любого пользователя ROCID, для этого необходимо указать уникальный ROCID профиля и нажать «Авторизоваться под ним».</p>
    </div>
    <div class="span10">
      <h4>Уникальаня ссылка</h4>
      <p>В случае, если необходимо помочь пользователю с входом на сайт, можно сгенерировать уникальную ссылку для быстрой авторизации. Сгенерированная ссылка является уникальной для каждого пользователя. В целях безопасности не передавайте ее третьим лицам. После смены пароля ссылка становится неактивной.</p>
    </div>
  </div>
  <form class="well" id="form_auth" action="" method="post">
    <div class="clearfix">
      <label for="rocid">rocID пользователя:</label>
      <div class="input">
        <input type="text" name="rocid" id="rocid" class="span3">
      </div>
    </div>
    <?if($this->AuthLink != ''):?>
      <div class="clearfix">
        <label for="authLink">Ссылка для авторизации:</label>
        <div class="input">
          <input type="text" name="authLink" id="authLink" class="span8" value="<?=$this->AuthLink;?>" disabled="disabled" />
        </div>
      </div>
    <?endif;?>
    <div class="clearfix">
      <button class="btn" type="submit" name="action" value="auth">Авторизоваться под ним</button>
      <button class="btn" type="submit" name="action" value="link">Ссылка для авторизации</button>
    </div>
  </form>
</section>

