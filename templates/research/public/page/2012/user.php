<div class="rocid-onesec">
  <div class="face"><img width="53" height="53" alt="" src="<?php echo $this->user->GetMiniPhoto();?>"></div>
  <div class="info">
    <h3><a href="<?php echo RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $this->user->RocId));?>"><?php echo $this->user->GetFullName();?></a><sup><?php echo $this->user->RocId;?></sup></h3>
    <?if ($this->user->GetPrimaryEmployment() !== null):?>
      <p><a href="<?php echo RouteRegistry::GetUrl('company', '', 'show', array('companyid' => $this->user->GetPrimaryEmployment()->Company->CompanyId))?>"><?php echo $this->user->GetPrimaryEmployment()->Company->Name;?></a></p>
    <?endif;?>
  </div>
</div>
<?php if ($this->flag):?>
  <div class="clear"></div>
<?php endif;?>