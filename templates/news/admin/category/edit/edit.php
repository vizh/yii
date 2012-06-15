<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
  <tbody><tr>
    <td>
      <h1>// Добавление категории</h1>
    </td>
  </tr>
  </tbody></table>

<form enctype="multipart/form-data" action="" method="post">

  <input type="hidden" value="<?=$this->NewsCategoryId;?>" name="cat_post_id">

  <table width="100%" cellpadding="3" border="0">
    <tbody>
    <tr>
      <td width="100%" valign="top" align="center">
        <table cellpadding="3" border="0">
          <tbody align="left">
          <tr bgcolor="#6d705d">
            <td colspan="2"><b><font color="#ffffff">[ДАННЫЕ]</font></b></td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td><strong>Заголовок:</strong><div class="copy">(Пример: СМИ)</div></td>
            <td width="500"><input type="text" style="width: 50%;" maxlength="250" name="data[title]" value="<?=$this->Title;?>"></td>
          </tr>
          <tr bgcolor="#e2e3dd">
            <td><b>Ссылка:</b><div class="copy">(Пример: smi)<br>
              Если пустая, генерируется автоматически из заголовка.</div></td>
            <td>
                <input type="text" style="width: 50%;" maxlength="250" name="data[name]" value="<?=$this->Name;?>">
            </td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
    </tbody>
  </table>
  <center><p><input type="submit" value="Сохранить категорию">&nbsp;<a href="/admin/news/list/category/">Назад</a></p></center>
</form>

 
