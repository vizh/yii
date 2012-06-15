<?php if (!$this->Empty): ?>
<table class="rocid-person">
<tr>
  <td class="i"><a href="/<?=$this->RocId?>"><img src="<?=$this->Photo?>" width="28" height="28" alt="" /></a></td>
  <td class="t">
  <h3><a href="/<?=$this->RocId?>"><?=$this->FirstName?> <?=$this->LastName?></a></h3><sup><?=$this->RocId?></sup>
<p><?=$this->Position?> </p>
  </td>
</tr>
</table>
<?php else: ?>
<div class="clear"></div>
<?php endif; ?>