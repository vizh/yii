<p><?php echo $user->GetFullName();?>, <span class='muted'>RUNET-ID <?php echo $user->RocId;?></span></p>
<?php $empoyment = $user->GetPrimaryEmployment();?>
<?php if ($empoyment !== null):?>
  <p class='muted'><?php echo $empoyment->Company->Name;?><?php if (!empty($empoyment->Position)):?>, <?php echo $empoyment->Position;?><?php endif;?></p>
<?php endif;?>
<img src='<?php echo $user->GetMiniPhoto();?>' alt='<?php echo $user->GetFullName();?>'>