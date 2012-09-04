<ul class="prevnext">
   <li class="p"><a href="<?=\Yii::app()->createUrl($this->url, array_merge(array('page' => $this->page > 1 ? $this->page-1 : 1), $this->params));?>" <?php if ($this->page == 1):?>class="inactive"<?php endif;?>>предыдущая</a></li>
   <li class="n"><a href="<?=\Yii::app()->createUrl($this->url, array_merge(array('page' => $this->page < $this->count ? $this->page+1 : $this->count), $this->params));?>" <?php if ($this->page == $this->count):?>class="inactive"<?php endif;?>>следующая</a></li>
 </ul>
 <div class="clear"></div>
 <ul class="paginator">
   <?=$pages;?>
 </ul>
<div class="clear"></div>