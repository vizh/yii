<div class="side-title">тест предоставлен</div>
<div class="right-banner">
  <? if (!empty($this->Url)):?>
  <a target="_blank" href="<?=$this->Url;?>">
    <img title="<?=$this->Title;?>" alt="<?=$this->Title;?>" src="<?=$this->ImageUrl;?>" style="border:none; max-height:100px; max-width:240px;">
  </a>
  <?else:?>
    <img title="<?=$this->Title;?>" alt="<?=$this->Title;?>" src="<?=$this->ImageUrl;?>" style="border:none; max-height:100px; max-width:240px;">
  <?endif;?>
</div>

 
