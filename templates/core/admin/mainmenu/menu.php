<nav>
  <?
  $i = 0;
  $size = sizeof($this->Items) - 1;
  foreach ($this->Items as $item):?>
    <a href="<?=$item['href'];?>"
       class="<?= $i==0 ? 'left' : ($i == $size ? 'right' : 'middle'); ?> pill
       big button <?=$this->Module == $item['module'] ? 'primary' : '';?>">
      <?=$item['title'];?>
    </a>
  <?
  $i++;
  endforeach;?>
</nav>