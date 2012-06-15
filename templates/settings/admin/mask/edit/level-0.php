<li data-id="<?=$this->StructureId;?>">
  <label><input type="checkbox" name="data[rules][<?=$this->StructureId;?>]" data-level="0" data-id="<?=$this->StructureId;?>" <?=$this->Checked ? 'checked="checked"' : '';?>><h4><?=$this->ModuleName;?></h4></label>
  <?if (! empty($this->Childs)):?>
  <ul>
    <?php echo $this->Childs;?>
  </ul>
  <?endif;?>
</li>