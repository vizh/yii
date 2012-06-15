<li data-id="<?=$this->StructureId;?>">
  <label><input type="checkbox" name="data[rules][<?=$this->StructureId;?>]" data-level="1" data-id="<?=$this->StructureId;?>" <?=$this->Checked ? 'checked="checked"' : '';?>><strong><?=$this->SectionName;?></strong></label>
  <?if (! empty($this->Childs)):?>
  <ul>
    <?php echo $this->Childs;?>
  </ul>
  <?endif;?>
</li>