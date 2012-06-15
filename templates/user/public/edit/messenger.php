<dl id="contact_<?=$this->ContactId;?>" class="<?=isset($this->Empty)? 'im_template' : 'im_info';?>">
  <dt>&nbsp;</dt>
  <dd>
    <input type="text" name="im_screenname" value="<?=htmlspecialchars($this->Name);?>" size="23">
    <select name="im_list" class="contact">
      <?foreach($this->ServiceTypes as $type):?>
      <?php
      if ($type->Protocol == 'facebook' || $type->Protocol == 'twitter')
      {
        continue;
      }
?>
        <option value="<?=$type->ServiceTypeId;?>" <?=$this->TypeId == $type->ServiceTypeId ? 'selected="selected"' : '';?>><?=$type->Title;?></option>
      <?endforeach;?>
    </select>
    <span class="connect"><a href="#" class="delete_messenger">удалить</a></span>
  </dd>
</dl>
 
