<li>
  <span class="time"><?=$this->Date;?> г.</span>
  <div class="job_title">
    <a href="<?=RouteRegistry::GetUrl('job', 'stream', 'show', array('id'=>$this->VacancyStreamId));?>"><?=$this->Title;?></a>
    <span class="salary"><span class="salary_end">
      <?if ($this->SalaryMin == $this->SalaryMax):?>
        <?=$this->SalaryMin;?>&nbsp;000
      <?elseif (empty($this->SalaryMin)):?>
        до&nbsp;<?=$this->SalaryMax;?>&nbsp;000
      <?elseif (empty($this->SalaryMax)):?>
        от&nbsp;<?=$this->SalaryMin;?>&nbsp;000
      <?else:?>
        <?=$this->SalaryMin;?>&nbsp;000&nbsp;&mdash;&nbsp;<?=$this->SalaryMax;?>&nbsp;000
      <?endif;?>&nbsp;рублей
    </span></span>
  </div>
  <div class="description">
    <p>
      <?=$this->DescriptionShort;?>
    </p>
  </div>
</li>