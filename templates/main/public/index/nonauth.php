<?php echo $this->FbRoot; ?>
<div id="top-block">
  <div id="gallery">
    <ul id="carousel-small">

      <?php echo $this->PromoTop;?>

    </ul>
  </div>
  <div class="login">
    <div class="login-top"></div>
    <div id="login-block" class="login_center <?php echo $this->ActiveForm == 'auth' ? '' : 'hide-block'; ?>">
      <div class="login_header">
        <div>Авторизоваться</div>
        <div><a id="select_registration" href="#">Зарегистрироваться</a></div>
      </div>
      <div class="login_text">ROCID - это  информационный портал для профессионалов Рунета. IT-мероприятия, новости, аналитика, видео, люди и компании на одном сайте. </div>
      <?php echo $this->AuthForm->Open(); ?>
      <div class="login_form">
        <label for="rocid_or_mail">E-mail / roc<span>ID</span>:</label>
        <?php echo $this->AuthForm->TextBox('rocid_or_mail', array('id' => "rocid_or_mail", 'class' => 'rocid_or_mail', 'classerror' => 'rocid_or_mail incorrect', 'placeholder' => 'введите свой rocID или e-mail', 'autocomplete' => 'off')); ?>
        <label for="password">Пароль:</label>
        <?php echo $this->AuthForm->Password('password', array('id' => 'password', 'class' => 'password', 'classerror' => 'password incorrect')); ?>
        <a href="#" onclick="$('#<?=$this->AuthForm->GetFormId();?>:first', $('#login-block')).trigger('submit'); return false;" class="auth_me">Войти</a>
        <div class="options">

          <label for="not_mine"><input name="notRemember" type="checkbox" class="not_mine" value="" /> не запоминать</label> <a id="send_pwd" class="send_pwd" href="<?=RouteRegistry::GetUrl('main', '', 'recovery');?>">напомнить пароль</a>
        </div>
      </div>
      <div class="social_login">
        <a class="fb_login" href="#" onclick="Social.FacebookConnect('/main/social/facebook/?call=' + encodeURIComponent(window.location.href)); return false;">&nbsp;</a>
        <a class="twi_login" href="#" onclick="Social.TwitterConnect('/main/social/twitter/?call=' + encodeURIComponent(window.location.href)); return false;">&nbsp;</a>
        <p>
          Вы можете авторизоваться или зарегистрироваться используя учётные записи Facebook или Twitter.
        </p>
      </div>
      <div class="clear">&nbsp;</div>
      <?php echo $this->AuthForm->Close(); ?>
    </div>
    <div id="registration-block" class="login_center <?php echo $this->ActiveForm == 'reg' ? '' : 'hide-block'; ?>">
      <div class="login_header">
        <div><a id="select_login" href="#">Авторизоваться</a></div>
        <div>Зарегистрироваться</div>
      </div>
<!--      <div class="login_text"> ROCID - это  информационный портал для профессионалов Рунета. IT-мероприятия, новости, аналитика, видео, люди и компании на одном сайте.  </div>-->
      <?php echo $this->RegForm->Open(); ?>
      <div class="login_form">
        <label for="lastname">Фамилия:</label>
        <?php echo $this->RegForm->TextBox('lastname', array('id' => "lastname", 'class' => 'rocid_or_mail', 'classerror' => 'rocid_or_mail incorrect', 'placeholder' => 'введите свою фамилию')); ?>
        <label for="firstname">Имя:</label>
        <?php echo $this->RegForm->TextBox('firstname', array('id' => "firstname", 'class' => 'rocid_or_mail', 'classerror' => 'rocid_or_mail incorrect', 'placeholder' => 'введите свое имя')); ?>
        <label for="email">Введите свой e-mail:</label>
        <?php echo $this->RegForm->TextBox('email', array('id' => "email", 'class' => 'rocid_or_mail', 'classerror' => 'rocid_or_mail incorrect', 'placeholder' => 'введите свой e-mail')); ?>
        <label for="password2">Введите желаемый пароль:</label>
        <?php echo $this->RegForm->Password('password', array('id' => 'password2', 'class' => 'password', 'classerror' => 'password incorrect')); ?>
        <a href="#" onclick="$('#<?=$this->RegForm->GetFormId();?>:first', $('#registration-block')).trigger('submit'); return false;" class="register_me">Зарегистрироваться</a>
      </div>
      <div class="social_login">
        <div class="login_text_register"></div>
        <a class="fb_login" href="#" onclick="Social.FacebookConnect('/main/social/facebook/?call=' + encodeURIComponent(window.location.href)); return false;">&nbsp;</a>
        <a class="twi_login" href="#" onclick="Social.TwitterConnect('/main/social/twitter/?call=' + encodeURIComponent(window.location.href)); return false;">&nbsp;</a>
        <p>
          Вы можете авторизоваться или зарегистрироваться используя учётные записи Facebook или Twitter.
        </p>
      </div>
      <div class="clear">&nbsp;</div>
      <?php echo $this->RegForm->Close(); ?>


    </div>
    <div class="login-bottom"></div>
  </div>
</div>
<?php echo $this->NewsTape;?>
<?php echo $this->AllNews;?>

<!-- modal content -->
<div id='confirm'>
  <div class='header'><span>Восстановление доступа</span></div>
  <div class='message cfldset'>
    <label><h3>Введите email, </h3></label>
    <p><input type="text" value="" autocomplete="off" name="data[fio]"></p>
  </div>
  <div class='buttons'>
    <div class='no simplemodal-close'>Отмена</div>
    <div class='nosave'>Не сохранять</div>
    <div class='save'>Сохранить</div>
  </div>
</div>