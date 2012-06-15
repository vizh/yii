<p>
<?php $d = getdate(strtotime($this->Date)); ?>
<?=$d['mday']?> <?=$this->words['calendar']['months'][2][$d['mon']]?><?php echo $this->Date == date('Y-m-d', time()) ? ' (сегодня)' : ''; ?>
<?php $place = $this->Place; echo empty($place) ? '' : ', ' . $place; ?>
</p>
