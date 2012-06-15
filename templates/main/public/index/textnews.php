<li>
  <span><?=$this->Date;?></span>
  <a href="/news/<?=$this->Link;?>/"><?=$this->Title;?></a>
  <?if (isset($this->Quote)):?>
    <p><?=$this->Quote;?></p>
  <?endif;?>

</li>