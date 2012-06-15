<div data-role="content">
<ul data-role="listview" class="event-list" data-splittheme="f">
  <li data-role="list-divider" class="head-event">
    <h1 class="normal-whitespace"><?=$this->SectionTitle;?></h1>
    <p><strong><?=$this->Start . ' &ndash; ' . $this->End;?></strong></p>
  </li>
  <?php if ($this->Actual): ?>
    <?php if ($this->CanCheckHere): ?>
    <li>
      <h3 class="normal-whitespace"><a href="/event/section/checkme/<?=$this->EventProgramId;?>/" data-rel="dialog">Отметиться на секции</a></h3>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>
    <?php endif; ?>
    <li>
      <h3 class="normal-whitespace"><a href="/event/section/userlist/<?=$this->EventProgramId;?>/">Список людей на секции</a></h3>
      <span class="ui-icon ui-btn-icon-notext ui-btn-corner-all ui-shadow ui-btn-up-f list-arrow"></span>
    </li>
  <?php else: ?>
    <?php if ($this->StartDate > time()): ?>
      <li>
        <h3 class="normal-whitespace">Доклады на секции еще не начались</h3>
      </li>
    <?php else: ?>
      <li>
        <h3 class="normal-whitespace">Все доклады на секции завершены</h3>
      </li>
    <?php endif; ?>
  <?php endif; ?>
  <li data-role="list-divider" class="head-event">
    <h3>Организаторы и ведущие</h3>
  </li>
  <?=$this->LeaderLinks;?>
  <li data-role="list-divider" class="head-event">
    <h3>Докладчики</h3>
  </li>
  <?=$this->UserLinks;?>  
  
</ul>
</div>