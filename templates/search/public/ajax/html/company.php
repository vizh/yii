<li>
  <a href="/company/<?=$this->CompanyId;?>/">
    <span class="c">компания://</span>&nbsp;<span class="p"><?=$this->Name;?></span> <br />
    <span class="a">
      <?if (isset($this->City)):?><?=$this->City;?>, <?endif;?>
    <?=Texts::GetRightFormByCount($this->EmployersCount, 'зарегистрирован', 'зарегистрировано', 'зарегистрированы');?>
    <?=$this->EmployersCount;?> <?=Texts::GetRightFormByCount($this->EmployersCount, 'сотрудник', 'сотрудника', 'сотрудников');?>
    </span>
  </a>
</li>