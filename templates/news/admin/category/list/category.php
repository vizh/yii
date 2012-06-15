<tr>
  <td>
    <?=$this->NewsCategoryId;?>
  </td>
  <td>
    <h2><?=$this->Title;?></h2>
  </td>
  <td>
    <?=$this->Name;?>
  </td>
  <td align="center">
    <a href="/admin/news/category/edit/<?=$this->NewsCategoryId;?>/">
      <img alt="Редактировать" title="Редактировать" style="border: none;" src="/templates/images/icons/edit.gif">
    </a>&nbsp;&nbsp;
    <a href="/admin/news/category/delete/<?=$this->NewsCategoryId;?>/" onclick="javascript:return confirm('Вы уверены, что хотите удалить категорию?');">
      <img alt="Удалить" title="Удалить" style="border: none;" src="/templates/images/icons/delete.gif">
    </a>
  </td>
</tr>
 
