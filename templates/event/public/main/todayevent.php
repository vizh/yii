
  <div class="tev-body">

    <div class="tev-pic"><a href="/events/<?=$this->IdName;?>/"><?if(! empty($this->Logo)):?><img src="<?=$this->Logo;?>" alt="<?=$this->Name;?>" /><?endif?></a></div>
    <div class="tev-nfo">

      <div class="tev-date">
        <?if ($this->DateStart['mon'] == $this->DateEnd['mon']):?>
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
        <!--<span class="wd">/ четверг</span>--></div>

      <h3><a href="/events/<?=$this->IdName;?>/"><?=$this->Name;?></a><br />
        <span><?=$this->Place;?></span></h3>

      <p><?=$this->Info;?></p>

      <p class="lnx"><a href="/events/<?=$this->IdName;?>/">Подробнее</a><!--&nbsp;&nbsp;<a href="">Участники</a>--></p>
      <!-- end tev-nfo -->
    </div>

    <div class="clear"></div>
    <!-- end tev-body -->
  </div>
