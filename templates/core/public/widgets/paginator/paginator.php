 <ul class="prevnext">
    <li class="p"><a href="<?=$this->BackLink?>" <?php if ($this->Page == 1):?>class="inactive"<?php endif;?>>предыдущая</a></li>
    <li class="n"><a href="<?=$this->NextLink?>" <?php if ($this->Page == $this->Count):?>class="inactive"<?php endif;?>>следующая</a></li>
  </ul>
  <div class="clear"></div>
  <ul class="paginator">
    <?=$this->Pages?>
  </ul>
<div class="clear"></div>