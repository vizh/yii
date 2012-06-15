<?php if (!$this->Empty): ?>
<div class="rocid-onesec">
<div class="face"><img src="<?=$this->Logo?>" width="53" height="53" alt="" /></div>
<div class="info">
<h3><a href="/company/<?=$this->CompanyId?>"><?=$this->Name?></a><sup>ID<?=$this->CompanyId?></sup></h3>
<p><?=$this->FullName?></p>
</div>
<!-- end rocid-onesec -->
</div>
<?php else: ?>
<div class="clear"></div>
<?php endif; ?>
