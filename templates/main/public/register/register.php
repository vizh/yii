<div class="twitter_register">
  <p>
    Для окончания регистрации введите свой Email.
  </p>
  <form id="TwiRegForm" action="/main/register/twitter" method="post">
    <input type="hidden" name="twitter" value="1">
    <input id="email" class="rocid_or_mail" type="text"
           onblur="if(this.value==''){this.value='введите свой Email'}"
           onfocus="if(this.value=='введите свой Email'){this.value=''}"
           value="введите свой Email" name="email">
    <a class="register_me" onclick="$('#TwiRegForm:first').trigger('submit'); return false;" href="#">Зарегистрироваться</a>
  </form>
</div>