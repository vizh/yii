
<ul class="pager">
  <li <?php if ($this->page == 1):?>class="disabled"<?php endif;?>>
    <a href="<?=$this->getUrl($this->page > 1 ? $this->page-1 : 1);?>">&larr;&nbsp;Предыдущая</a>
  </li>
  <li <?php if ($this->page == $this->count):?>class="disabled"<?php endif;?>>
    <a href="<?=$this->getUrl($this->page < $this->count ? $this->page+1 : $this->count);?>">Следующая&nbsp;&rarr;</a>
  </li>
</ul>
<div class="pagination pagination-centered">
  <ul>
    <?foreach ($pages as $page):?>
      <li <?php if ($page->current): ?>class="active"<?php endif;?>><a href="<?=$page->url;?>"><?=$page->value;?></a></li>
    <?endforeach;?>
  </ul>
</div>