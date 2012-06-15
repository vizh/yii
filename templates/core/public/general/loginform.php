<form name="toplogin" id="topLogin" action="/main/auth" method="post" onkeypress="javascript:if (event.keyCode==13) document.toplogin.submit();">
  <input type="hidden" name="fastLogin" value="1"/>
  <table cellspacing="3" align="right" style="border: 0; position: relative; top: 12px; padding:6px; background-color: #F0F4F7;">
    <tr valign="bottom">
      <td class="simple_label">roc<b>ID</b>:<br /><input type="text" name="RocId" id="RocId" style="width: 77px;"/></td>

      <td class="simple_label">Пароль:<br /><input type="password" name="Password" id="Password" style="width: 83px;"/></td>
      <td><ul class="nav"><li><a href="javascript:document.toplogin.submit();"><span style="color: #FFFFFF;">Войти</span></a></li></ul></td>
    </tr>
    <tr><td colspan="5" align="center"><a href="/registration/">Регистрация</a>&nbsp;|&nbsp;<a href="/profile.php?show=recovery">Восстановление пароля</a></td></tr>
  </table>
</form>