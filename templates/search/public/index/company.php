<li>
  <a href="/company/<?=$this->CompanyId;?>/"><?=$this->Name;?></a>
  <span class="info">
    <?if (isset($this->City)):?><?=$this->City;?>, <?endif;?>
    <?=Texts::GetRightFormByCount($this->EmployersCount, 'зарегистрирован', 'зарегистрировано', 'зарегистрированы');?>
    <?=$this->EmployersCount;?> <?=Texts::GetRightFormByCount($this->EmployersCount, 'сотрудник', 'сотрудника', 'сотрудников');?></span>
</li>
