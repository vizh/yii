<?php
/**
 * @var $this \application\widgets\Paginator
 */
?>

<ul class="pager">
  <li <?if($this->paginator->page == 1):?>class="disabled"<?endif?>>
    <a href="<?=$this->paginator->getUrl($this->paginator->page > 1 ? $this->paginator->page-1 : 1)?>">&larr;&nbsp;Предыдущая</a>
  </li>
  <li <?if($this->paginator->page == $this->paginator->getCountPages()):?>class="disabled"<?endif?>>
    <a href="<?=$this->paginator->getUrl($this->paginator->page < $this->paginator->getCountPages() ? $this->paginator->page+1 : $this->paginator->getCountPages())?>">Следующая&nbsp;&rarr;</a>
  </li>
</ul>
<div class="pagination pagination-centered">
  <ul>
    <?foreach($this->paginator->getPages() as $page):?>
      <li <?if($page->current):?>class="active"<?endif?>><a href="<?=$page->url?>"><?=$page->value?></a></li>
    <?endforeach?>
  </ul>
</div>