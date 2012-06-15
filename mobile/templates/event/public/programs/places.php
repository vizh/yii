<?php foreach ($this->Places as $key => $value): 
if ($value == 'default')
{
  continue;
}
?>

<li>
  <h3>
    <a href="/event/programs/<?=$this->EventIdName;?>/<?=$this->Date;?>/<?=$key;?>/">
      <?=$value?>
    </a>
  </h3>
  <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
</li>

<?php endforeach; ?>
