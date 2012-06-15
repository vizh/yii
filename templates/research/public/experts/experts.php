<?php
/** @var $trends Trend[] */
$trends = $this->Trends;
?>

<h1 class="event">Исследовательский проект «Экономика Рунета 2011-2012» <br>
  <span class="count">список экспертов по рынкам</span></h1>

<div id="large-left" class="event-content">
  <!-- content -->
  <?foreach ($trends as $trend):
      if (empty($trend->Experts))
      {
        continue;
      }
  ?>
  <h2 style="margin-bottom: 15px;"><?=$trend->Title;?></h2>
    <? $flag = true;
    foreach ($trend->Experts as $expert): $flag = !$flag;?>
      <div class="rocid-onesec">
        <div class="face"><img width="53" height="53" alt="" src="<?=$expert->GetMiniPhoto();?>"></div>
        <div class="info">
          <h3><a href="<?=RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $expert->RocId));?>"><?=$expert->LastName;?> <?=$expert->FirstName;?></a><sup><?=$expert->RocId;?></sup></h3>
          <?if ($expert->GetPrimaryEmployment() != null):?>
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
  <?endforeach;?>
  <div class="clear"></div>
  <!-- end large-left -->
</div>
<div class="sidebar sidebarrapple">

  <?php echo $this->Banner;?>

  <!-- end sidebar -->
</div>

<div class="clear"></div>