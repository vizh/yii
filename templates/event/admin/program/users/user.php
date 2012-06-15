<tr data-link-id="<?=$this->LinkId;?>">
  <td>
    <strong><?=$this->Order;?></strong>
  </td>
  <td class="i">
    <img alt="" src="<?=$this->Photo;?>">
  </td>
  <td><strong><?=$this->FullName;?></strong></td>
  <td>rocID: <?=$this->RocId?></td>
  <td>
    <?=$this->Role;?><br>
    <?if (!empty($this->LinkPresentation)):?>
      <span style="color: #0a0;">есть презентация</span>
    <?else:?>
      <span style="color: #f00;">нет презентации</span>
    <?endif;?>
  </td>
  <td class="controls">
    <a href="" class="button button_edit">
      <span class="pen icon"></span>
    </a>
    &nbsp;&nbsp;
    <a onclick="javascript:return confirm('Вы уверены, что хотите удалить участника программы?');" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'userdelete', array('linkId' => $this->LinkId));?>" class="button negative button_delete">
      <span class="trash icon"></span>
    </a>
  </td>
</tr>
