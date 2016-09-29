<p><?=$user->GetFullName()?>, <span class='muted'>RUNET-ID <?=$user->RocId?></span></p>
<?$empoyment = $user->GetPrimaryEmployment()?>
<?if($empoyment !== null):?>
  <p class='muted'><?=$empoyment->Company->Name?><?if(!empty($empoyment->Position)):?>, <?=$empoyment->Position?><?endif?></p>
<?endif?>
<img src='<?=$user->GetMiniPhoto()?>' alt='<?=$user->GetFullName()?>'>