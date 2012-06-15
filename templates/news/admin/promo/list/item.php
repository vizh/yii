<tr>
  <td>
    <h2><?=! empty($this->TitleTop) ? $this->TitleTop : $this->words['news']['emptytitle'];?></h2>
    <h3><?=$this->Title;?></h3>
    <?=$this->Quote;?>
  </td>
  <td class="date">
    <span>
      <?=$this->Position;?>
    </span>
  </td>
  <td>
    <p>
      <b>Тип: </b>
      <?if ($this->Status == NewsPromo::StatusPublish):?>
        <span style="color: #0a0;">
      <?elseif ($this->Status == NewsPromo::StatusHide):?>
        <span style="color: #b00;">
      <?else:?>
        <span>
      <?endif;?>
        <?=$this->words['status'][$this->Status];?>
      </span>
    </p>
  </td>
  <td align="center">
    <a href="/admin/news/promo/edit/<?=$this->NewsPromoId;?>/">
      <img alt="Редактировать" title="Редактировать" style="border: none;" src="/templates/images/icons/edit.gif">
    </a>&nbsp;&nbsp;
    <a href="/admin/news/promo/delete/<?=$this->NewsPromoId;?>/" onclick="javascript:return confirm('Вы уверены, что хотите удалить новость и ВСЕ ее данные?');">
      <img alt="Удалить" title="Удалить" style="border: none;" src="/templates/images/icons/delete.gif">
    </a>
  </td>
</tr>