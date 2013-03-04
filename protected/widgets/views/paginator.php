<?php
/**
 * @var $this \application\widgets\Paginator
 */
?>

<ul class="pager">
  <li <?php if ($this->paginator->page == 1):?>class="disabled"<?php endif;?>>
    <a href="<?=$this->paginator->getUrl($this->paginator->page > 1 ? $this->paginator->page-1 : 1);?>">&larr;&nbsp;Предыдущая</a>
  </li>
  <li <?php if ($this->paginator->page == $this->paginator->getCountPages()):?>class="disabled"<?php endif;?>>
    <a href="<?=$this->paginator->getUrl($this->paginator->page < $this->paginator->getCountPages() ? $this->paginator->page+1 : $this->paginator->getCountPages());?>">Следующая&nbsp;&rarr;</a>
  </li>
</ul>
<div class="pagination pagination-centered">
  <ul>
    <?foreach ($this->paginator->getPages() as $page):?>
      <li <?php if ($page->current): ?>class="active"<?php endif;?>><a href="<?=$page->url;?>"><?=$page->value;?></a></li>
    <?endforeach;?>
  </ul>
</div>