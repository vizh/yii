<nav>
  <?
  $i = 0;
  $size = sizeof($this->Items) - 1;
  foreach ($this->Items as $item):?>
      <a href="<?=$item['href'];?>"
         class="<?= $size == 0 ? '' : ($i==0 ? 'left' : ($i == $size ? 'right' : 'middle')); ?> <?=$this->Active == $item['fullname'] ? 'primary' : '';?> button">
        <?=$item['title'];?>
      </a>
  <?
  $i++;
  endforeach;?>
<div class="cl"></div>
</nav>