<?php foreach ($this->Items as $item): 

$start = date('H:i', strtotime($item->DatetimeStart));
$end = date('H:i', strtotime($item->DatetimeFinish));

$title = stripslashes($item->Title);
?>

<?php if (! empty($item->Place)): ?>
<li>
  <p class="event-time"><strong><?=$start . ' &ndash; ' . $end;?></strong></p>
  <h3 class="normal-whitespace">
    <a href="/event/section/<?=$item->EventProgramId;?>/">
      <?=$title;?>
    </a>
  </h3>
  
  <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
</li>
<?php else: ?>
<li>
  <p class="event-time"><strong><?=$start . ' &ndash; ' . $end;?></strong></p>
  <h3 class="normal-whitespace">
      <?=$title;?>
  </h3>
</li>
<?php endif; ?>

<?php endforeach; ?>
