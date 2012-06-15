<div class="content">
  <?php echo $this->Submenu;?>

  <div class="vacancies">
    <ul>
      <li>
        <span class="time"><?=$this->Date;?> г.</span>
        <div class="job_title">
          <a href="<?=RouteRegistry::GetUrl('job', 'stream', 'show', array('id'=>$this->VacancyStreamId));?>"><?=$this->VacancyTitle;?></a>
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
        <div class="description_full">
          <?=$this->Description;?>
        </div>
        <div class="additional_info">
          <?if (! empty($this->CompanyId)):?>
          <p class="company">Работодатель: <a href="<?=RouteRegistry::GetUrl('company', '', 'show', array('companyid' => $this->CompanyId));?>"><?=$this->CompanyName;?></a></p>
          <?endif;?>
        </div>
        <div class="response">
          <a target="_blank" href="<?=$this->Link;?>">Просмотреть вакансию</a>
        </div>

      </li>

    </ul>
  </div>
  <div id="sidebar" class="sidebar sidebarcomp">
    <?php echo $this->PartnerBanner;?>
    <?php echo $this->Banner;?>
  </div>
</div>
