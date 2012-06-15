<li>
  <a href="/<?=$this->RocId;?>/"><?=$this->LastName;?> <?=$this->FirstName;?></a><span class="id">ID://<?=$this->RocId;?></span>
  <span class="info">
    <?=$this->CompanyName;?><?if (!empty($this->CompanyName) && !empty($this->CompanyPosition)):?>, <?endif;?>
    <?=$this->CompanyPosition;?>
  </span>
</li>