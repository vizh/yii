<tr>
  <td class="logo"><img src="<?=$this->Event->GetMiniLogo();?>" alt="<?=$this->Event->Name;?>" /></td>
  <td>
    <h3><?php echo ! empty($this->Event->Name) ? $this->Event->Name : $this->words['news']['emptytitle'];?></h3>
    <?php echo $this->Event->Info;?>
  </td>
  <td class="date">
    <?php
      $dateStart = getdate( strtotime($this->Event->DateStart));
      $dateEnd   = getdate (strtotime($this->Event->DateEnd));
    ?>
    <?php if ($this->Event->DateStart == $this->Event->DateEnd
              && substr($this->Event->DateStart, 8, 2) == '00'):?>
      <?php echo $this->words['calendar']['months'][1][$dateStart['mon']%12+1];?>
    <?php elseif ($dateStart['mon'] == $dateEnd['mon']):?>
      <strong>
      <?php if ($dateStart['mday'] == $dateEnd['mday']):?>
        <?php echo $dateStart['mday'];?>
      <?php else:?>
        <?php echo $dateStart['mday'];?>-<?php echo $dateEnd['mday'];?>
      <?php endif;?>
      </strong>
      <?php echo $this->words['calendar']['months'][2][$dateStart['mon']];?>
    <?php else:?>
      <strong><?php echo $dateStart['mday'];?></strong> <?php echo $this->words['calendar']['months'][2][$dateStart['mon']];?>-<strong><?php echo $dateEnd['mday'];?></strong> <?php echo $this->words['calendar']['months'][2][$dateEnd['mon']];?>
    <?php endif;?>
    <?php echo $dateStart['year']?>
    <br/><br/>
    <?php echo $this->Event->Place;?>
  </td>
  <td class="type">
    <strong>Тип:</strong> <?if ($this->Event->Type == 'own'):?>Собственное<?else:?>Партнёрское<?endif;?>
  </td>
  <td class="controls">
    <a class="btn btn-primary m-bottom_10" href="<?php echo RouteRegistry::GetAdminUrl('event', 'program', 'list', array('eventId' => $this->Event->EventId));?>">
      <span class="icon-calendar"></span> Программа
    </a>
    <div class="clearfix">
      <a class="btn pull-left" href="<?php echo RouteRegistry::GetAdminUrl('event', '', 'edit', array('id'=>$this->Event->EventId));?>">
        <span class="icon-edit"></span>
      </a>
      <a class="btn pull-right" href="<?php echo RouteRegistry::GetAdminUrl('event', '', 'delete', array('id'=>$this->Event->EventId));?>" onclick="javascript:return confirm('Вы уверены, что хотите удалить мероприятие и удалить в профилях пользователей отметку об участии в нем?');">
        <span class="icon-trash"></span>
      </a>
    </div>
  </td>
</tr>
 
