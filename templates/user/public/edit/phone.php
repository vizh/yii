<dl id="phone_<?=$this->Id;?>" class="<?=isset($this->Empty)? 'phone_template' : 'phone_info';?>">
    <dt><?if($this->FirstPhone):?>Телефоны:<?else:?>&nbsp;<?endif;?></dt>
    <dd>
      <input type="text" name="phone" value="<?=$this->Phone;?>" size="23">
      <select name="phone_list" class="contact">
        <?php
        $phoneTypes = $this->words['phones'];
        foreach ($phoneTypes as $key => $value):?>
        <option value="<?=$key;?>" <?=$key == $this->Type ? 'selected="selected"':'';?>><?=htmlspecialchars($value);?></option>
        <?endforeach;?>
      </select>
      <span class="connect"><a href="#" class="delete_phone">удалить</a></span>
    </dd>
  </dl>
 
