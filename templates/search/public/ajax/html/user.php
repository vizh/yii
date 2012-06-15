<li>
  <a href="/<?=$this->RocId;?>/">
    <span class="c">люди://</span>&nbsp;<span class="p"><?=$this->LastName;?> <?=$this->FirstName;?></span><br />
    <span class="a">
      <?=$this->CompanyName;?><?if (!empty($this->CompanyName) && !empty($this->CompanyPosition)):?>, <?endif;?>
      <?=$this->CompanyPosition;?>
    </span>
  </a>
</li>