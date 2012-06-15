<section class="main">
  <a class="button positive" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'add', array('eventId' => $this->EventId));?>"><span class="plus icon"></span>Добавить пункт программы</a>
  <h2>Программа мероприятия <?=$this->Name;?></h2>
  <?php echo $this->Days;?>
</section>
 
