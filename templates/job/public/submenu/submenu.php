<div id="content-nav">
  <ul>
    <li <?= $this->Active == Vacancy::TypeTop ? 'class="active"':'';?>>
      <a href="<?=RouteRegistry::GetUrl('job', '', 'top');?>">ТОП вакансий</a>
    </li>
    <li <?= $this->Active == 'stream' ? 'class="active"':'';?>>
      <a href="<?=RouteRegistry::GetUrl('job', '', 'stream');?>">Поток вакансий</a>
    </li>
    <li <?= $this->Active == Vacancy::TypeStartup ? 'class="active"':'';?>>
      <a href="<?=RouteRegistry::GetUrl('job', '', 'startup');?>">Вакансии для студентов/стартапов</a>
    </li>
    <li <?= $this->Active == 'test' ? 'class="active"':'';?>>
      <a href="<?=RouteRegistry::GetUrl('job', 'test', 'list');?>">Профессиональные тесты</a>
    </li>
  </ul>
</div>