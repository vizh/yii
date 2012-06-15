<dl>
  <dt>
    <?if ($this->DateStart['mon'] == $this->DateEnd['mon']):?>
      <span class="number">
        <?if ($this->DateStart['mday'] == $this->DateEnd['mday']):?>
          <?=$this->DateStart['mday'];?>
        <?else:?>
          <?=$this->DateStart['mday'];?>-<?=$this->DateEnd['mday'];?>
        <?endif;?>
      </span><br><?=$this->words['calendar']['months'][2][$this->DateStart['mon']];?>
    <?else:?>
      <span class="number"><?=$this->DateStart['mday'];?></span>
    <?=$this->words['calendar']['months'][2][$this->DateStart['mon']];?>&nbsp;-<br>
    <span class="number"><?=$this->DateEnd['mday'];?></span> <?=$this->words['calendar']['months'][2][$this->DateEnd['mon']];?>
    <?endif;?>
  </dt>
  <dd><?=$this->Name;?>
    <ul class="whattodo">
      <li><?if(!empty($this->UrlRegistration)):?>
        <a target="_blank" class="join" href="<?=$this->UrlRegistration;?>">принять участие</a>
        <?endif;?></li>
      <li><a href="<?=!empty($this->Url)? $this->Url : '/events/' . $this->IdName . '/';?>">сайт мероприятия</a></li>
      <!--<li><a href="#">сообщить знакомым</a></li>-->
    </ul>
  </dd>
</dl>
<?if (! isset($this->Last)):?>
<div class="line"></div>
<?endif;?>