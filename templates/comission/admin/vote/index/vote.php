<tr>
  <td><?=htmlspecialchars($this->Vote->Title);?></td>
  <td><?=$this->Vote->Description;?></td>
  <td><?=!empty($this->Vote->Comission) ? $this->Vote->Comission->Title : 'не задана';?></td>
  <td>
    <?=$this->Vote->Status;?>
  </td>
  <td>
    <a href="<?=RouteRegistry::GetAdminUrl('comission', 'vote', 'edit', array('id' => $this->Vote->VoteId));?>" class="button">
      <span class="pen icon"></span>
    </a>
    <!--&nbsp;&nbsp;
    <a onclick="javascript:return confirm('Вы уверены, что хотите удалить голосование и ВСЕ его данные?');" href="<?=RouteRegistry::GetAdminUrl('comission', 'vote', 'delete', array('id' => $this->Vote->VoteId));?>" class="button negative">
      <span class="trash icon"></span>
    </a>-->
  </td>
</tr>
 
