<div class="content">
  <?php echo $this->Submenu;?>

  <div class="vacancies">
    <!-- <div class="field_filter">
     <h3>Фильтр вакансий</h3>
   </div> -->
    <ul>
      <?php echo $this->Vacancies; ?>
    </ul>
  </div>

  <div id="sidebar" class="sidebar sidebarcomp">
    <?php echo $this->PartnerBanner;?>
    <div class="response">
      <a href="<?=RouteRegistry::GetUrl('job', 'add', 'vacancy');?>">Добавить вакансию</a>
    </div>
    <?php echo $this->Banner;?>
  </div>

</div>


