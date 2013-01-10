<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?php echo \Yii::t('app', 'Мероприятия');?></span>
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
      <a href="javascript:void(null);" class="pull-left current">
        <img src="/images/blank.gif" alt="" class="i-event-layout i-event_list">
      </a>
      <a href="<?php echo $this->createUrl('/event/list/calendar', array('Month' => $month, 'Year' => $year));?>" class="pull-left">
        <img src="/images/blank.gif" alt="" class="i-event-layout i-event_calendar">
      </a>
    </div>
  <?php echo \CHtml::endForm();?>
</div>

<div class="events-list">
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

    <div class="row p-relative">
      <button class="btn btn-info event-button_add">
        <div class="plus">+</div>
        <div class="text"><?php echo \Yii::t('app', 'Добавить');?><br><?php echo \Yii::t('app', 'мероприятие');?></div>
      </button>
      
      <div class="span8 offset2">
        <?php if (!empty($events)):?>
          <?php foreach ($events as $event):?>
            <div class="event">
              <div class="type span2">
                <img src="/images/blank.gif" alt="" class="i-event_medium i-event_conference">
                <p>Конференция</p>
              </div>
              <div class="datetime">
                <div class="line"></div>
                <span class="date backing">
                  <span class="day"><?php echo $event->StartDay;?></span>
                  <span class="month"><?php echo \Yii::app()->locale->getMonthName($event->StartMonth);?></span>
                  <?php if ($event->StartDay != $event->EndDay):?>
                    &ndash;
                    <span class="day"><?php echo $event->EndDay;?></span>
                    <span class="month"><?php echo \Yii::app()->locale->getMonthName($event->EndMonth);?></span>
                  <?php endif;?>
                </span>
                <span class="day-of-the-week backing pull-right">
                  <?php echo \Yii::app()->dateFormatter->format('EEEE', mktime(0,0,0,$event->StartMonth,$event->StartDay,$event->StartYear));?>
                  <?php if ($event->StartDay != $event->EndDay):?>
                    &ndash; <?php echo \Yii::app()->dateFormatter->format('EEEE', mktime(0,0,0,$event->EndMonth,$event->EndDay,$event->EndYear));?>
                  <?php endif;?>
                </span>
              </div>
              <header>
                <h2 class="title">
                  <a href="<?php echo $this->createUrl('/event/view/index', array('idName' => $event->IdName));?>"><?php echo $event->Title;?></a>
                </h2>
                <p class="location">Москва, Крокус Экспо</p>
              </header>
              <article>
                <p><?php echo $event->Info;?></p>
              </article>
              <footer>
                <nav>
                  <a href="<?php echo $this->createUrl('/event/view/index', array('idName' => $event->IdName));?>"><i class="icon-circle-arrow-right"></i><?php echo \Yii::t('app', 'Посетить мероприятие');?></a>
                  <a href="#"><i class="icon-comment"></i><?php echo \Yii::t('app', 'Комментировать');?></a>
                  <a href="#"><i class="icon-share"></i><?php echo \Yii::t('app', 'Поделиться');?></a>
                </nav>
              </footer>
            </div>
          <?php endforeach;?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>

<ul class="pager">
  <li class="disabled"><a href="#">&larr;&nbsp;<?php echo \Yii::t('app', 'Новые');?></a></li>
  <li><a href="#"><?php echo \Yii::t('app', 'Старые');?>&nbsp;&rarr;</a></li>
</ul>