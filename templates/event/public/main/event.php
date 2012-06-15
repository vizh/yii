<div class="event3-item <?=$this->IdName == 'riw11' ? 'selected' : '';?>">
<div class="pic"><?if(! empty($this->Logo)):?><a href="/events/<?=$this->IdName;?>/"><img src="<?=$this->Logo;?>" alt="<?=$this->Name;?>" /></a><?endif?></div>
<div class="event3-item-nfo">
<div class="tev-date">
  <?if ($this->EmptyDay):?>
    <?=$this->words['calendar']['months'][1][$this->DateStart['mon']%12+1];?>
  <?elseif ($this->DateStart['mon'] == $this->DateEnd['mon']):?>
      <span class="d">
        <?if ($this->DateStart['mday'] == $this->DateEnd['mday']):?>
          <?=$this->DateStart['mday'];?>
        <?else:?>
          <?=$this->DateStart['mday'];?>-<?=$this->DateEnd['mday'];?>
        <?endif;?>
      </span> <?=$this->words['calendar']['months'][2][$this->DateStart['mon']];?>
    <?else:?>
      <span class="d"><?=$this->DateStart['mday'];?></span> <?=$this->words['calendar']['months'][2][$this->DateStart['mon']];?>
      - <span class="d"><?=$this->DateEnd['mday'];?></span> <?=$this->words['calendar']['months'][2][$this->DateEnd['mon']];?>
    <?endif;?>
  <span class="y"><?=$this->DateStart['year'];?></span>

</div>
<h3><a href="/events/<?=$this->IdName;?>/"><?=$this->Name;?></a><br />
<span><?=$this->Place;?></span></h3>
<p><?=$this->Info;?></p>
<!-- <p class="lnx"><a href="/events/<?=$this->IdName;?>/">Подробнее</a></p> -->
<!-- end nfo -->
</div>
<div class="clear"></div>
<!-- end event3-item -->
</div>