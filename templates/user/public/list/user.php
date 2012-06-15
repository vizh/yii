<?php if (!$this->Empty): ?>
<div class="rocid-onesec">
<div class="face"><img src="<?=$this->Photo?>" width="53" height="53" alt="" /></div>
<div class="info">
<h3><a href="/<?=$this->RocId?>"><?=$this->LastName?> <?=$this->FirstName?></a><sup><?=$this->RocId?></sup></h3>
<p><a href="/company/<?=$this->CompanyId?>"><?=$this->CompanyName?></a></p>
</div>
<!-- end rocid-onesec -->
</div>
<?php else: ?>
<div class="clear"></div>
<?php endif; ?>