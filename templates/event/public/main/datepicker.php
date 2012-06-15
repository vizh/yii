<div id="calendar-ch-year" class="calendar-choose" data-default="<?=date('Y');?>">
  <a id="year-val" year="<?=$this->Year?>" href=""><?=$this->Year?></a>
  <div id="datepicker-year" class="select_date_picker">
    <?php for ($i = $this->StartYear; $i <= $this->EndYear; $i++): ?>
    <a id="<?=$i?>" href="#"><?=$i?></a><br />
    <?php endfor; ?>
  </div>
</div>

<div id="calendar-ch-month" class="calendar-choose" data-default="<?=date('m');?>">
  <a id="month-val" month="<?=$this->Month?>" href=""><?=$this->words['calendar']['months'][1][$this->Month]?></a>
  <div id="datepicker-month" class="select_date_picker">
    <?php for ($i = 1; $i <= 12; $i++): ?>
    <a id="<?=$i?>" href="#"><?=$this->words['calendar']['months'][1][$i]?></a><br />
    <?php endfor; ?>
  </div>
</div>
