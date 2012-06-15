<h1 class="event">Исследовательский проект «Экономика Рунета 2011-2012»</h1>

<div id="large-left" class="event-content">
	<!-- content -->
  <h2 style="margin-bottom: 15px;">В исследовании приняли участие</h2>

  <? $flag = true;
      foreach ($this->Users as $user):/** @var $user User */ $flag = !$flag;?>
        <div class="rocid-onesec">
          <div class="face"><img width="53" height="53" alt="" src="<?=$user->GetMiniPhoto();?>"></div>
          <div class="info">
            <h3><a href="<?=RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $user->RocId));?>"><?=$user->GetFullName();?></a><sup><?=$user->RocId;?></sup></h3>
            <?if (false)://$user->GetPrimaryEmployment() != null):?>
            <p><a href="<?=RouteRegistry::GetUrl('company', '', 'show', array('companyid' => $expert->GetPrimaryEmployment()->Company->CompanyId))?>"><?=$expert->GetPrimaryEmployment()->Company->Name;?></a></p>
            <?endif;?>
          </div>
          <!-- end rocid-onesec -->
        </div>
        <?if ($flag):?>
          <div class="clear"></div>
        <?endif;?>
      <?endforeach;?>

<div class="clear"></div>

<!-- end large-left -->
</div>
<div class="sidebar sidebarrapple">

 <?php echo $this->Banner;?>

<!-- end sidebar -->
</div>

  <div class="clear"></div>