
<ul class="pager">
  <li <?php if ($this->page == 1):?>class="disabled"<?php endif;?>><a href="<?=\Yii::app()->createUrl($this->url, array_merge(array('page' => $this->page > 1 ? $this->page-1 : 1), $this->params));?>">&larr;&nbsp;Следующая</a></li>
  <li <?php if ($this->page == $this->count):?>class="disabled"<?php endif;?>><a href="<?=\Yii::app()->createUrl($this->url, array_merge(array('page' => $this->page < $this->count ? $this->page+1 : $this->count), $this->params));?>">Предыдущая&nbsp;&rarr;</a></li>
</ul>
<div class="pagination pagination-centered">
  <ul>
    <?foreach ($pages as $page):?>
      <li <?php if ($page->current): ?>class="active"<?php endif;?>><a href="<?=$page->url;?>"><?=$page->value;?></a></li>
    <?endforeach;?>
  </ul>
</div>