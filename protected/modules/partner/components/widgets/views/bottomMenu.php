<ul class="nav nav-pills">
  <?foreach ($this->menu as $item):?>
  <?if ($item['Access']):?>
    <li <?if ($item['Active']):?>class="active"<?endif;?>>
      <a href="<?=$item['Url'];?>"><?=$item['Title'];?></a>
    </li>
    <?endif;?>
  <?endforeach;?>
</ul>