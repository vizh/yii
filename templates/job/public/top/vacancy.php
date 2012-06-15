<li>
  <span class="time"><?=$this->Date;?> г.</span>
  <div class="job_title">
    <a href="<?=RouteRegistry::GetUrl('job', '', 'show', array('id'=>$this->VacancyId));?>"><?=$this->Title;?></a>
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
  <div class="additional_info">
    <?if (! empty($this->CompanyId)):?>
    <p class="company">Работодатель: <a href="<?=RouteRegistry::GetUrl('company', '', 'show', array('companyid' => $this->CompanyId));?>"><?=$this->CompanyName;?></a></p>
    <?endif;?>
  </div>
</li>