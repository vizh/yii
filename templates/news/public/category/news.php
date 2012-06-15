<li>
  <?if (!empty($this->Image)):?>
  <div class="list-image">
    <a href="/news/<?=$this->Link;?>/"><img src="<?=$this->Image;?>" alt="<?=$this->Title;?>"></a>
  </div>
  <?endif;?>
  <span><?=$this->Date;?></span>
  <a href="/news/<?=$this->Link;?>/"><?=$this->Title;?></a>
  <p><?=$this->Quote;?></p>
  <div class="clear"></div>
</li>