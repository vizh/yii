<div id="contentUpdate">
  <form action="" method="post">
    <input type="hidden" value="edit" name="action">
    <input type="hidden" value="<?=$this->CompanyId;?>" name="id" id="company_id">

    <table width="100%" cellpadding="3" border="0">
      <tbody>
      <tr align="center">
        <td width="100%" valign="top">
          <table cellpadding="3" border="0">
            <tbody align="left">
            <tr bgcolor="#6d705d">
              <td style="color: #ffffff; font-weight: bold;" colspan="2">[RSS КОМПАНИИ]</td>
            </tr>
            <tr bgcolor="#e2e3dd">
              <td>
                <strong>Ссылка на rss компании:</strong>
                <div class="copy">(Пример: http://www.company.ru/rss/)</div>
              </td>
              <td>
                <input type="text" maxlength="255" value="<?=$this->RssLink;?>" style="width: 300px;" name="data[rss]">
              </td>
            </tr>
            </tbody>
          </table>
        </td>
      </tr>
      </tbody>
    </table>
    <center><p><input type="submit" value="Сохранить" name="s"></p></center>
  </form>
</div>
