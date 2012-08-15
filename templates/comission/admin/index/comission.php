<tr>
  <td>
    <h3><?=htmlspecialchars($this->Comission->Title);?></h3>
    <?=$this->Comission->Description;?>
  </td>
  <!--<td><?=sizeof($this->Comission->ComissionUsers);?></td>-->
  <td style="padding-top: 25px; white-space: nowrap;">
    <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'users', array('id' => $this->Comission->ComissionId));?>" class="button"><span class="user icon"></span></a>
    <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'edit', array('id' => $this->Comission->ComissionId));?>" class="button"><span class="pen icon"></span></a>
    <a onclick="javascript:return confirm('Вы уверены, что хотите удалить комиссию и ВСЕ ее данные?');" href="" class="button negative"><span class="trash icon"></span></a>
  </td>
</tr>
 
