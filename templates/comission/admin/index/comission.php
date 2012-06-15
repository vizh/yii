<tr>
  <td><?=htmlspecialchars($this->Comission->Title);?></td>
  <td><?=$this->Comission->Description;?></td>
  <!--<td><?=sizeof($this->Comission->ComissionUsers);?></td>-->
  <td>
    <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'users', array('id' => $this->Comission->ComissionId));?>" class="button">
    <span class="user icon"></span>
  </a>
    &nbsp;&nbsp;
    <a href="<?=RouteRegistry::GetAdminUrl('comission', '', 'edit', array('id' => $this->Comission->ComissionId));?>" class="button">
      <span class="pen icon"></span>
    </a>
    &nbsp;&nbsp;
    <a onclick="javascript:return confirm('Вы уверены, что хотите удалить комиссию и ВСЕ ее данные?');" href="" class="button negative">
      <span class="trash icon"></span>
    </a>
  </td>
</tr>
 
