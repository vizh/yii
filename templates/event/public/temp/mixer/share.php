<ul class="sharethis">
  <div id="ya_share_container" data-event-name="<?=htmlspecialchars($this->Name);?>" data-event-url="<?=$this->Url;?>">
    <div id="ya_share"></div>
  </div>
  <li>
    <a id="share_friends" href="" class="sht-friends">
      <span>Поделитесь с друзьями</span>
    </a>

  </li>
  <li>
    <a href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?=urlencode($this->Name);?>&dates=<?=$this->GoogleDateStart;?>/<?=$this->GoogleDateEnd;?>&details=<?=urlencode('');?>&location=<?=urlencode($this->Place);?>"
       target="_blank" class="sht-gcalendar">
      <span>Экспорт в Google Calendar</span>
    </a>
  </li>
  <!--<li>
    <a id="facebook-export" href="" class="sht-facebook"
       event-name="<?=htmlspecialchars($this->Name);?>" event-start="<?=strtotime($this->DateStart);?>"
       event-finish="<?=strtotime($this->DateEnd);?>" event-description="<?=htmlspecialchars($this->Info);?>"
       event-picture="http://<?=$this->SiteHost;?><?=$this->LogoImage;?>">
      <span>Экспорт в Facebook</span>
    </a>
  </li>-->
  <li>
    <a target="_blank" href="webcal://<?=$this->SiteHost;?>/event/share/ical/<?=$this->IdName;?>/" class="sht-ical">
      <span>Экспорт в iCal</span>
    </a>
  </li>
</ul>