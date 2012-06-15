<?php if (! $this->Date): ?>
<li data-role="list-divider" class="head-event"><h1>Выберите текущее мероприятие:</h1></li>
<?php else: ?>
<li data-role="list-divider" class="head-date"><?=$this->Date['mday']?> <?=$this->words['calendar']['months'][2][$this->Date['mon']]?> <?=$this->Date['year']?> года</li>
<?php endif;?>