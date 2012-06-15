<tr>
  <td>
    <h3><?=! empty($this->Title) ? $this->Title : $this->words['news']['emptytitle'];?></h3>
    <?=$this->Quote;?>
  </td>
  <td class="date"><span><?=$this->Date['mday']?> <?=$this->words['calendar']['months'][2][$this->Date['mon']];?>
    <?=$this->Date['year']?>
    <?=$this->Date['hours']?>:<?=intval($this->Date['minutes']) < 10 ? '0' . $this->Date['minutes'] : $this->Date['minutes'];?>
  </span></td>
  <td>
    <p>
      <b>Тип: </b>
      <?if ($this->Status == VacancyStream::StatusPublish):?>
        <span style="color: #0a0;">
      <?elseif ($this->Status == VacancyStream::StatusDraft):?>
        <span style="color: #a00;">
      <?elseif ($this->Status == VacancyStream::StatusDeleted):?>
        <span style="color: #f00;">
      <?else:?>
        <span>
      <?endif;?>
      <?=$this->words['status'][$this->Status];?>
    </span>
    </p>
  </td>
  <td class="controls">
    <a class="button" href="<?=RouteRegistry::GetAdminUrl('job', 'stream', 'edit', array('id' => $this->VacancyStreamId));?>">
      <span class="pen icon"></span>
    </a>
    <?if ($this->Status != VacancyStream::StatusDeleted):?>
    &nbsp;&nbsp;
    <a class="button negative" href="<?=RouteRegistry::GetAdminUrl('job', 'stream', 'delete', array('id' => $this->VacancyStreamId));?>" onclick="javascript:return confirm('Вы уверены, что хотите удалить вакансию?');">
      <span class="trash icon"></span>
    </a>
    <?endif;?>
  </td>
</tr>
 
