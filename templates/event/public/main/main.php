<div id="large-left">
  <?=$this->TodayEvent;?>
  <h1 class="calendar">МЕРОПРИЯТИЯ</h1>
  <?=$this->DatePicker?>

  <ul class="choose-calend-view">
    <li><a id="ActivateList" href="" class="this">списком</a></li>
    <li><a id="ActivateCalendar" href="" class="ln">календарем</a></li>
  </ul>

  <div class="clear"></div>
  <div id="calendar-list">
    <?=$this->Events?>
  </div>

  <div class="clear"></div>
  <!-- end large-left -->
</div>


<div id="sidebar" class="sidebar sidebarcomp">
  <div class="response">
    <a href="<?=RouteRegistry::GetUrl('event', '', 'add');?>">Добавить мероприятие</a>
  </div>
  <?php echo $this->Banner;?>
</div>
<div class="clear"></div>
<div id="calendar-body"></div>