<tr>
  <td>
    <?=$this->CompanyName;?>
  </td>
  <td>
    <h2><?=! empty($this->Title) ? $this->Title : $this->words['news']['emptytitle'];?></h2>
    <?=$this->Quote;?>
  </td>
  <td class="date"><span><?=$this->Date['mday']?> <?=$this->words['calendar']['months'][2][$this->Date['mon']];?>
    <?=$this->Date['year']?>
    <?=$this->Date['hours']?>:<?=intval($this->Date['minutes']) < 10 ? '0' . $this->Date['minutes'] : $this->Date['minutes'];?>
  </span></td>
  <td>
    <p>
      <strong>Тип: </strong>
      <?if ($this->Status == NewsPost::StatusPublish):?>
        <span style="color: #0a0;"><?=$this->words['status'][$this->Status];?></span>
      <?elseif ($this->Status == NewsPost::StatusModerate):?>
        <span style="color: #a00;"><?=$this->words['status'][$this->Status];?></span><br>
        <a href="/admin/news/status/<?=$this->NewsPostId;?>/<?=NewsPost::StatusPublish?>/">опубликовать</a>
      <?elseif ($this->Status == NewsPost::StatusDeleted):?>
        <span style="color: #f00;"><?=$this->words['status'][$this->Status];?></span>
      <?else:?>
        <span><?=$this->words['status'][$this->Status];?></span>
      <?endif;?>
    </p>
  </td>
  <td align="center">
    <a href="/admin/news/edit/<?=$this->NewsPostId;?>/">
      <img alt="Редактировать" title="Редактировать" style="border: none;" src="/templates/images/icons/edit.gif">
    </a>
    <?if ($this->Status != NewsPost::StatusDeleted):?>
    &nbsp;&nbsp;
    <a href="/admin/news/delete/<?=$this->NewsPostId;?>/" onclick="javascript:return confirm('Вы уверены, что хотите удалить новость и ВСЕ ее данные?');">
      <img alt="Удалить" title="Удалить" style="border: none;" src="/templates/images/icons/delete.gif">
    </a>
    <?endif;?>
  </td>
</tr>