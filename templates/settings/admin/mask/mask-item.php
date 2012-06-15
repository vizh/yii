<tr>
  <td>
    <h3><?=! empty($this->Title) ? $this->Title : $this->words['news']['emptytitle'];?></h3>
  </td>
  <td>
    <p>
      <b>Тип: </b>
      <?if ($this->Type == CoreMask::TypePersonal):?>
        <span style="color: #0a0;">
      <?else:?>
        <span style="color: #a00;">
      <?endif;?>
      <?=$this->words['type'][$this->Type];?>
    </span>
    </p>
  </td>
  <td class="controls">
    <a class="button" href="<?=RouteRegistry::GetAdminUrl('settings', 'mask', 'edit', array('id' => $this->MaskId));?>">
      <span class="pen icon"></span>
    </a>
    <?if ($this->Type != CoreMask::TypeSystem):?>
    &nbsp;&nbsp;
    <a class="button negative" href="<?=RouteRegistry::GetAdminUrl('settings', 'mask', 'delete', array('id' => $this->MaskId));?>" onclick="javascript:return confirm('Вы уверены, что хотите удалить маску доступа?');">
      <span class="trash icon"></span>
    </a>
    <?endif;?>
  </td>
</tr>