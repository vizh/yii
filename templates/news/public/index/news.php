<li>
  <span>
    <?=$this->Date;?>
    <?if (!empty($this->MaterialType)):?>
    <span class="material-type"><?=$this->MaterialType?></span>
    <?endif;?>
  </span>
  <a href="/news/<?=$this->Link;?>/"><?=$this->Title;?></a>
  <p><?=$this->Quote;?></p>
</li>