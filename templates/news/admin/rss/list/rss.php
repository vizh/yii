<tr>
  <td>
    <?=$this->NewsRssId;?>
  </td>
  <td>
    <?=$this->Link;?>
  </td>
  <td class="date">
    <span>
      <?=$this->LastUpdate;?> / <?=$this->NextUpdate;?>
    </span>
  </td>
  <td>
    <a href="/admin/company/edit/<?=$this->CompanyId;?>/"><?=$this->CompanyName;?></a>
  </td>
  <td align="center">
    <a href="/admin/news/rss/update/<?=$this->NewsRssId;?>/">
      Обновить
    </a>
  </td>
</tr>