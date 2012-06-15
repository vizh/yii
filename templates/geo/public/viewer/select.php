<select id="<?=$this->Id;?>" name="<?=$this->Name?>" <?=!empty($this->CssClass)? 'class="'.$this->CssClass.'"' : '';?>>
  <?foreach($this->List as $item):?>
    <option value="<?=$item['id'];?>" <?=$item['id']==$this->Selected? 'selected="selected"':'';?>><?=$item['name'];?></option>
  <?endforeach;?>
</select>