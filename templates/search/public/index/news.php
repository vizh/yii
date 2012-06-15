<li>
  <a href="/news/<?=$this->Link;?>/"><?=$this->Title;?></a>
  <span class="id"><?=$this->Date['mday'];?> <?=$this->words['calendar']['months'][2][$this->Date['mon']];?> <?=$this->Date['year'];?></span>
  <span class="info"><?if (isset($this->Quote)):?>…<?=$this->Quote;?>…<?endif;?></span>
</li>
