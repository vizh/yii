<div data-role="content">
  <ul data-role="listview" class="event-list" data-splittheme="f">
    <li data-role="list-divider" class="head-event">
      <h3 class="normal-whitespace">Вы отметились на секции:</h3>
      <p class="normal-whitespace"><strong><?=$this->SectionTitle;?></strong></p>
    </li>
    <li data-icon="arrow-l">
      <h3><a href="" 
        onclick="$('.ui-dialog').dialog('close'); window.location.reload();">Назад</a></h3>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>
  </ul>
</div>
