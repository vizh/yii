<div data-role="content">
  <ul data-role="listview" class="event-list" data-splittheme="f">
    <li data-role="list-divider" class="head-event"><h1 class="normal-whitespace"><?=$this->Name;?></h1></li>
  </ul>
  <p class="event-info">
    <img class="event-logo" src="<?=$this->MiniLogo;?>" alt="" title="<?=$this->Name;?>"><?=$this->Info;?>
  </p>
  <ul class="event-list" data-role="listview" data-splittheme="f">
    <li data-role="list-divider" class="head-event event-info-divider"></li>
    <li>
      <h3 class="normal-whitespace"><a href="/event/programs/<?=$this->IdName;?>/<?=$this->Date;?>/">Программа мероприятия</a></h3>
      <p class="normal-whitespace"><strong>Карта мероприятия, сетка выступлений</strong></p>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>
    <li>
      <h3 class="normal-whitespace"><a href="/event/users/<?=$this->IdName;?>/">Участники</a></h3>
      <p class="normal-whitespace"><strong>Список ваших знакомых и других участников</strong></p>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>
    <!--<li>
      <h3 class="normal-whitespace"><a href="/event/twitter/<?=$this->IdName;?>/">Twitter с хештегом #<?=$this->IdName?></a></h3>
      <p class="normal-whitespace"><strong>Лента сообщений Twitter о мероприятии</strong></p>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>-->
  </ul>
</div>
