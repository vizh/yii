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
    <?php echo \CHtml::activeTextField($filter, 'Query', array('placeholder' => \Yii::t('app', 'Поиск мероприятия'), 'class' => 'span5'));?>
    <?php echo \CHtml::imageButton('/images/search-type-image-light.png', array('width' => '20', 'height' => '19', 'class' => 'form-element_image'));?>
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
      <div class="span8 offset2">
        <?php if (!empty($events)):?>
          <?php foreach ($events as $event):?>
            <?$today = (date('d.m.Y') >= $event->getFormattedStartDate('dd.MM.yyyy') && date('d.m.Y') <= $event->getFormattedEndDate('dd.MM.yyyy'));?>
            <div class="event <?if($event->getFormattedEndDate('dd.MM.yyyy') < date('d.m.Y')):?>past<?endif;?> <?if($today):?>today<?endif;?>">
              <?if ($today):?>
                <div class="label-today"><span class="label label-success"><?=\Yii::t('app', 'Сегодня');?></span></div>
              <?endif;?>
              <div class="type span2">
                <img src="/images/blank.gif" alt="" class="i-event_medium <?=$event->Type->CssClass;?>">
                <p><?=$event->Type->Title;?></p>
              </div>
              <div class="datetime">
                <div class="line"></div>
                <span class="date backing">
                  <?$this->widget('\event\widgets\Date', array('event' => $event));?>
                </span>
                <span class="day-of-the-week backing pull-right">
                  <?=$event->getFormattedStartDate('EEEE');?>
                  <?php if ($event->StartDay != $event->EndDay || $event->StartMonth != $event->EndMonth):?>
                    &ndash; <?=$event->getFormattedEndDate('EEEE');?>
                  <?php endif;?>
                </span>
              </div>
              <header>
                <h2 class="title">
                  <a href="<?php echo $this->createUrl('/event/view/index', array('idName' => $event->IdName));?>"><?php echo $event->Title;?></a>
                </h2>
                <?php if ($event->LinkAddress !== null):?>
                  <p class="location"><?php echo $event->LinkAddress->Address;?></p>
                <?php endif;?>
              </header>
              <article>
                <p><?php echo $event->Info;?></p>
              </article>
              <footer>
                <nav>
                  <a href="<?php echo $this->createUrl('/event/view/index', array('idName' => $event->IdName));?>"><i class="icon-circle-arrow-right"></i><?php echo \Yii::t('app', 'Посетить мероприятие');?></a>
                  <!--
                  <a href="#"><i class="icon-comment"></i><?php echo \Yii::t('app', 'Комментировать');?></a>
                  <a href="#"><i class="icon-share"></i><?php echo \Yii::t('app', 'Поделиться');?></a>
                  -->
                </nav>
              </footer>
            </div>
          <?php endforeach;?>
        <?php endif;?>
        <div id="event-button_action">
          <a href="<?=$this->createUrl('/event/create/index');?>" class="btn btn-info event-button_add">
            <div class="plus">+</div>
            <div class="text"><?php echo \Yii::t('app', 'Добавить');?><br><?php echo \Yii::t('app', 'мероприятие');?></div>
          </a>
        </div>
      </div>
    </div>
  </div>
    
  <ul class="pager">
    <li><a href="<?=$prevMonthUrl;?>">&larr;&nbsp;<?php echo \Yii::t('app', 'Старые');?></a></li>
    <li><a href="<?=$nextMonthUrl;?>"><?php echo \Yii::t('app', 'Новые');?>&nbsp;&rarr;</a></li>
  </ul>
</div>