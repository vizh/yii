<div class="content">
  <div class="vacancies add-vacancy">
    <h2>Поздравляем!</h2>
    <p>Вы успешно зарегистрировались на мероприятии <strong><?=$this->Event->Name;?></strong> под статусом "<?php echo $this->Role->Name;?>".</p>
    <p><a href="<?=RouteRegistry::GetUrl('event', '', 'show', array('idName' => $this->Event->IdName));?>">Страница мероприятия</a></p>
  </div>
  <div id="sidebar" class="sidebar sidebarcomp">
    <?php echo $this->Banner;?>
  </div>
</div>