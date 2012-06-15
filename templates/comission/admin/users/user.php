<?
/**
 * @var $cUser ComissionUser
 */
$cUser = $this->CUser;
?>
<tr>
  <td class="i">
    <img border="0" alt="" src="<?=$cUser->User->GetMiniPhoto();?>">
  </td>
  <td><strong><?=$cUser->User->LastName;?> <?=$cUser->User->FirstName;?></strong></td>
  <td><?=$cUser->Role->Name;?></td>
  <td><a title="Удалить" class="button negative" href="<?=RouteRegistry::GetAdminUrl('comission', 'user', 'delete', array('id' => $cUser->ComissionUserId));?>"><span class="icon trash"></span></a></td>
</tr>
