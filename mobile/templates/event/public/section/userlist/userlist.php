<ul data-role="listview" class="event-list" data-splittheme="f">
  <li data-role="list-divider" class="head-event">
    <h1 class="normal-whitespace"><?=$this->SectionTitle;?></h1>
    <p><strong><?=$this->Start . ' &ndash; ' . $this->End;?></strong></p>
    <p>Список присутствующих участников</p>
  </li>
</ul>
<ul data-role="listview" data-filter="true">
  <?=$this->UserList;?>  
</ul>