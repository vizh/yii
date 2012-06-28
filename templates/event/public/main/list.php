<?php if (!$this->ActualEventIsEmpty):?>
	<h2 class="red-angled">Важное</h2>
	<?php echo $this->ActualEvents;?>
<?php endif;?>


<?if (!$this->NextEventsIsEmpty):?>
<h2 class="red-angled">В <?=$this->Month;?></h2>
<?php echo $this->NextEvents;?>
<?elseif ($this->PrevEventsIsEmpty):?>
<h2 class="grey-angled">В <?=$this->Month;?></h2>
<h3 style="margin: 0 0 20px 30px;">
  <?if ($this->Date[0] < date('Y') || $this->Date[1] < date('m')):?>
  В этом месяце нет мероприятий, но в следующем много интересного!
  <?else:?>
  В этом месяце не было мероприятий.
  <?endif;?>
</h3>
<?endif;?>

<?if (!$this->PrevEventsIsEmpty):?>
<h2 class="grey-angled">Прошедшие</h2>
<?endif;?>
<?if ($this->PrevEvents->Count() > 1 && $this->ShowEventsButton):?>
<div>
  <div id="PrevEvents">
    <?php echo $this->PrevEvents;?>
  </div>
</div>
<a class="allevents" href="">
  <span data-role="show">Показать все прошедшие мероприятия</span>
  <span data-role="hide" class="hide">Скрыть прошедшие мероприятия</span>
</a>
<div class="clear"></div>
<?else:?>
<?php echo $this->PrevEvents;?>
<?endif?>

<div id="event3-paginator">
  <a href="" id="be3p">Назад</a>
  <a href="" id="fe3p">Вперед</a>
  <div class="clear"></div>
  <!-- end event3-paginator -->
</div>


<div class="clear"></div>