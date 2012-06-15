<div data-role="content">
<ul data-role="listview" class="event-list" data-splittheme="f">
  <li data-role="list-divider" class="head-event">
    <h1 class="normal-whitespace"><?=$this->Name;?></h1>
    <p><strong>Программа мероприятия</strong></p>
    <?=$this->PlaceInfo;?>
  </li>
  <?php echo $this->ListContent; ?>
</ul>
</div>