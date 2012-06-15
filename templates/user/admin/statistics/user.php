<tr>
  <td class="i">
    <img src="<?=$this->Photo;?>" alt="" border="0">
  </td>
  <td><strong><?=$this->FullName;?></strong></td>
  <td>rocID: <?=$this->RocId;?></td>
  <td><a href="mailto:<?=$this->Email;?>"><?=$this->Email;?></a></td>
  <td><a target="_blank" href="<?=RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $this->RocId));?>">Просмотреть профиль</a></td>
</tr>
