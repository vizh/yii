<?php foreach ($this->Dates as $date): 
$d = getdate(strtotime($date));
?>

<li>
  <h3>
    <a href="/event/programs/<?=$this->EventIdName;?>/<?=$date;?>/">
      <?=$d['mday']?> <?=$this->words['calendar']['months'][2][$d['mon']]?><?php echo $date == $this->CurrentDay ? ' (сегодня)' : ''; ?>
    </a>
  </h3>
  <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
</li>

<?php endforeach; ?>