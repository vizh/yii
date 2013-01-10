<div id="b-fixed"></div>
<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text">Мероприятия</span>
    </div>
  </div>
</h2>

<div class="container">
  <?php echo \CHtml::form('', 'POST', array('class' => 'form-inline form-filter span12'));?>
    <?php echo \CHtml::activeDropDownList($filter, 'Type', $filter->getTypeList($month, $year),array('class' => 'span3 form-element_select'));?>
    <?php echo \CHtml::activeDropDownList($filter, 'City', $filter->getCityList($month, $year),array('class' => 'span3 form-element_select'));?>
    <?php echo \CHtml::activeTextField($filter, 'Query', array('placeholder' => \Yii::t('app', 'Поиск'), 'class' => 'span3'));?>
    <?php echo \CHtml::imageButton('/images/search-type-image-light.png', array('width' => '20', 'height' => '19', 'class' => 'form-element_image'));?>
    <div class="clearfix pull-right switch-layout">
      <a href="<?php echo $this->createUrl('/event/list/index', array('Month' => $month, 'Year' => $year));?>" class="pull-left">
        <img src="/images/blank.gif" alt="" class="i-event-layout i-event_list">
      </a>
      <a href="javascript:void(null);" class="pull-left current">
        <img src="/images/blank.gif" alt="" class="i-event-layout i-event_calendar">
      </a>
    </div>
  <?php echo \CHtml::endForm();?>
</div>

<div class="events-calendar">

  <div class="container">
    <div class="row">
      <div class="events-month-select datetime span2 offset5">
        <a href="<?php echo $prevMonthUrl;?>" class="nav prev">
          <i class="icon-arrow-left"></i>
        </a>
        <div class="date">
          <h3 class="month"><?php echo \Yii::app()->locale->getMonthName($month,'wide',true);?></h3>
          <p class="year"><?php echo $year;?></p>
        </div>
        <a href="<?php echo $nextMonthUrl;?>" class="nav next">
          <i class="icon-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <div id="events-calendar_content" class="container">

    <button class="btn btn-info event-button_add">
      <div class="plus">+</div>
      <div class="text"><?php echo \Yii::t('app', 'Добавить');?><br><?php echo \Yii::t('app', 'мероприятие');?></div>
    </button>

    <?php if (!empty($events)):?>
      <?php foreach ($events as $event):?>
        <?php
          if ($event->StartMonth !== $event->EndMonth)
          {
            $startMonthDayCount = date('t', mktime(0,0,0, $event->StartMonth,$event->StartDay,$event->StartYear));
            $dateDuration = $startMonthDayCount - $event->StartDay + $event->EndDay;
          }
          else
          {
            $dateDuration = $event->EndDay - $event->StartDay;
          }
        ?>
        <div class="event" data-startdate="<?php echo $event->StartYear;?>/<?php echo $event->StartMonth;?>/<?php echo $event->StartDay;?>" data-duration="<?php echo ($dateDuration+1);?>">
          <div class="details">
            <header>
              <p class="muted"><small><?php echo $event->Type->Title;?></small></p>
              <h5 class="title">
                <a href="<?php echo $this->createUrl('/event/view/index', array('idName' => $event->IdName));?>" class="event-color_1"><?php echo $event->Title;?></a>
              </h5>
              <p class="muted"><small><?php echo ($event->StartMonth == $event->EndMonth ? $event->StartDay.'-'.$event->EndDay.' '.\Yii::app()->locale->getMonthName($event->StartMonth) : $event->StartDay.' '.\Yii::app()->locale->getMonthName($event->StartMonth).' - '.$event->EndDay.' '.\Yii::app()->locale->getMonthName($event->EndMonth)).($event->getContactAddress() !== null ? ', '.$event->getContactAddress() : '');?></small></p>
            </header>
            <article>
              <?php echo $event->Info;?>
            </article>
            <footer>
              <nav>
                <a href="<?php echo $this->createUrl('/event/view/index', array('idName' => $event->IdName));?>"><i class="icon-circle-arrow-right"></i><small><?php echo \Yii::t('app', 'Посетить мероприятие');?></small></a>
                <a href="#"><i class="icon-comment"></i><small><?php echo \Yii::t('app', 'Комментировать');?></small></a>
                <a href="#"><i class="icon-share"></i><small><?php echo \Yii::t('app', 'Поделиться');?></small></a>
              </nav>
            </footer>
          </div>
        </div>
      <?php endforeach;?>
    <?php else:?>
    
    <?php endif;?>
  </div>
</div>
