<div class="rocid-onesec">
  <div class="face"><img width="53" height="53" alt="" src="<?php echo $this->user->GetMiniPhoto();?>"></div>
  <div class="info">
    <h3><a href="<?php echo RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $this->user->RocId));?>" target="_blank"><?php echo $this->user->GetFullName();?></a><sup><?php echo $this->user->RocId;?></sup></h3>
    <?if ($this->user->GetPrimaryEmployment() !== null):?>
      <p><?php echo $this->user->GetPrimaryEmployment()->Company->Name;?></p>
    <?endif;?>
  </div>
</div>