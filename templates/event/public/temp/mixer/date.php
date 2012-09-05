<div class="event-top-date">
<?php if ($this->OneMonth): ?>
<span>
  <?=$this->OneDay ? $this->Start['mday'] : $this->Start['mday'] . '-' . $this->End['mday']?>
</span> <?=$this->words['calendar']['months'][2][$this->Start['mon']]?>
<?php else: ?>
<span><?=$this->Start['mday']?></span> <?=$this->words['calendar']['months'][2][$this->Start['mon']]?> - <span><?=$this->End['mday']?></span> <?=$this->words['calendar']['months'][2][$this->End['mon']]?>
<?php endif; ?>
</div>

