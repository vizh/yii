<div class="content">
  <?php echo $this->Submenu;?>

  <div class="vacancies">
    <ul>
      <li>
        <span class="time">14 июня 2011 г.</span>
        <div class="job_title">
          <a href="<?=RouteRegistry::GetUrl('job', '', 'show', array('id'=>$this->VacancyId));?>"><?=$this->VacancyTitle;?></a>
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

        <?php echo $this->Request;?>


      </li>

    </ul>
  </div>
  <div id="sidebar" class="sidebar sidebarcomp">
    <?php echo $this->PartnerBanner;?>
    <?php echo $this->Banner;?>
  </div>
</div>