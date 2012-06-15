<?php if ($this->Report): ?>
<li data-icon="plus">
  <?php if ($this->Actual): ?>
    <h3 class="normal-whitespace" ><a href="/event/section/like/<?=$this->ReportId;?>" data-rel="dialog"><?=$this->Report;?></a></h3> 
  <?php else: ?>
    <h3 class="normal-whitespace" ><?=$this->Report;?></h3> 
  <?php endif; ?>    
  <p class="normal-whitespace"><?=$this->LastName . ' ' . $this->FirstName?></p>
  <?php if ($this->Actual): ?>
    <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
  <?php endif; ?>
</li>
<?php endif; ?> 