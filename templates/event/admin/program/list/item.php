<div class="section" style="width: <?=$this->Width;?>px">
  <?if ($this->Type == EventProgram::ProgramTypeFull):?>
  <h5><?=$this->Section;?>&nbsp;</h5>
  <a href="<?=$this->EventProgramId;?>"><?=$this->Title;?></a><br>
  <em><?=$this->Place;?></em><br>
  <?else:?>
    <h5><?=$this->Title;?></h5>
    <em><?=$this->Place;?></em><br>
  <?endif;?>
  <a class="button" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'edit', array('id' => $this->EventProgramId));?>">
    <span class="pen icon"></span>
  </a>
  <a class="button" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'users', array('id' => $this->EventProgramId));?>">
    <span class="user icon"></span>
  </a>
  <a class="button negative" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'delete', array('id' => $this->EventProgramId));?>" onclick="javascript:return confirm('Вы уверены, что хотите удалить пункт программы?');">
    <span class="trash icon"></span>
  </a>
</div>