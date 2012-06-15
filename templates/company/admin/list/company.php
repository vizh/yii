<tr onmouseover="style.backgroundColor='#C1FBC1';" onmouseout="style.backgroundColor='#e2e3dd';" style="background-color: rgb(226, 227, 221);">
  <td align="center" style="color: #C0C0C0"><?=$this->CompanyId;?></td>
  <td>
    <a title="Редактирование данных" href="/admin/company/edit/<?=$this->CompanyId?>/"><?=$this->Name;?></a>
  </td>
  <td>
    <a href="mailto:<?=$this->Email;?>"><?=$this->Email;?></a>
  </td>
  <td align="center"><?=$this->CountryName;?></td>
  <td align="center"><?=$this->CityName;?></td>
  <td align="center" style="font-size: 10px;"><?=$this->Created;?> / <?=$this->Updated;?></td>
  <td align="center" height="25px">
    <a href="/admin/company/edit/<?=$this->CompanyId?>/">
      Редактировать
    </a>&nbsp;
    <a href="/admin/company/delete/<?=$this->CompanyId?>/" onclick="javascript:return confirm('Вы уверены, что хотите удалить компанию?');">
      Удалить
    </a>
  </td>
</tr>