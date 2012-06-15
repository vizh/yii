<!-- td class="favorited"  если подписался на участие -->

<td>
  <?if (isset($this->EventsHide)):?>
  <div class="hidden-events">
    <div class="<?=$this->ClassTitle?>">
    <span><?=$this->Day?></span> <?=$this->words['calendar']['months'][2][$this->Month]?>
  </div>
    <?=$this->EventsHide;?>
  </div>
  <?endif;?>
  <div class="<?=$this->ClassTitle?>">
    <span><?=$this->Day?></span> <?=$this->words['calendar']['months'][2][$this->Month]?>
  </div>
  <?=$this->Event;?>
  <?if (! isset($this->EventsHide)):?>
  <?elseif ($this->EventsHide->Count() > 1):?>
  <ul>
    <li><a class="event-details" href="">И еще 2 мероприятия</a></li>
  </ul>
  <?else:?>
  <ul>
    <li><a class="event-details" href="">Подробнее</a></li>
  </ul>
  <?endif;?>
</td>