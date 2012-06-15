<tr>
  <td>
    <h3><?=! empty($this->Name) ? $this->Name : $this->words['news']['emptytitle'];?></h3>
    <?=$this->Info;?><br><br>
    <a class="button" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'list', array('eventId' => $this->EventId));?>">
      <span class="calendar icon"></span>Программа
    </a>
  </td>
  <td class="date">
    <?if ($this->EmptyDay):?>
    <?=$this->words['calendar']['months'][1][$this->DateStart['mon']%12+1];?>
    <?elseif ($this->DateStart['mon'] == $this->DateEnd['mon']):?>
    <strong>
        <?if ($this->DateStart['mday'] == $this->DateEnd['mday']):?>
      <?=$this->DateStart['mday'];?>
      <?else:?>
      <?=$this->DateStart['mday'];?>-<?=$this->DateEnd['mday'];?>
      <?endif;?>
      </strong> <?=$this->words['calendar']['months'][2][$this->DateStart['mon']];?>
    <?else:?>
    <strong><?=$this->DateStart['mday'];?></strong> <?=$this->words['calendar']['months'][2][$this->DateStart['mon']];?>
    - <strong><?=$this->DateEnd['mday'];?></strong> <?=$this->words['calendar']['months'][2][$this->DateEnd['mon']];?>
    <?endif;?> <?=$this->DateStart['year']?>
    <br><br>
    <?=$this->Place;?>
  </td>
  <td>
    <strong>Тип:</strong> <?if ($this->Type == 'own'):?>Собственное<?else:?>Партнёрское<?endif;?>
  </td>
  <td class="controls">
    <a class="button" href="<?=RouteRegistry::GetAdminUrl('event', '', 'edit', array('id'=>$this->EventId));?>">
      <span class="pen icon"></span>
    </a>
    &nbsp;&nbsp;
    <a class="button negative" href="<?=RouteRegistry::GetAdminUrl('event', '', 'delete', array('id'=>$this->EventId));?>" onclick="javascript:return confirm('Вы уверены, что хотите удалить новость и ВСЕ ее данные?');">
      <span class="trash icon"></span>
    </a>
  </td>
</tr>
 
