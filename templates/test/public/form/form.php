<div id="login">
<div id="login-top"></div>
						<div id="login-center">
								<div id="login-header">
										<div>Авторизоваться</div>
										<div><a href="#">Зарегистрироваться</a></div>
								</div>
								<div id="login-text"> rocID – это единая сеть участников всех мероприятий РОЦИТа. Используя систему rocID Вы получаете возможность участвовать в ярких IT-мероприятиях. </div>
								
<?php echo $this->Form->Open(array('id'=>'test')); ?>

<?php echo $this->Form->TextBox('rocid', array('value' => "введите свой номер rocID или email", 'onfocus' => "if(this.value=='введите свой номер rocID или email'){this.value=''}", 'onblur' => "if(this.value==''){this.value='введите свой номер rocID или email'}", 'class' => 'text')); ?>

<?php echo $this->Form->TextBox('password', array('value' => "введите свой пароль", 'onfocus' => "if(this.value=='введите свой пароль'){this.value=''; this.type = 'password';}", 'onblur' => "if(this.value==''){this.value='введите свой пароль';  this.type = 'text';}", 'class' => 'text')); ?>

<div id="login-links">
																<label><?php echo $this->Form->CheckBox('rememberMe', 'on', array('class' => 'checkbox')); ?>
																запомнить меня</label> &nbsp;<a href="#">восстановить пароль</a>
																</div>
																
<?php echo $this->Form->Image('submit', '/images/login-button.gif'); ?>


<?php echo $this->Form->Close(); ?>
</div>
						<div id="login-bottom"></div>
</div>

<div class="clear"></div>