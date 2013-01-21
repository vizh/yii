<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo">
  <div class="container">
    <div class="row">
      <div class="side left span4">
        <img src="<?=$event->getLogo()->getNormal();?>" alt="" class="logo">
      </div>
      
      <div class="details span4 offset4">
        <h2 class="title"><?=$event->Title;?></h2>
        <div class="type">
          <img src="/images/blank.gif" alt="" class="i-event_small <?=$event->Type->CssClass;?>"><?=$event->Type->Title;?>
        </div>
        <div class="duration">
          <span class="datetime">
            <span class="date">
              <?$this->render('header-date');?>
            </span>
          </span>
        </div>
        <?if ($event->getContactAddress() != null && !empty($event->getContactAddress()->Place)):?>
        <div class="location"><?=$event->getContactAddress()->Place;?></div>
        <?endif;?>
      </div>
      
      <div class="side right span4">
        <div class="actions">
          <div class="calendar img-circle">
            <a href="#" class="pseudo-link">
              <i class="icon-calendar"></i><br>Добавить в&nbsp;календарь
            </a>
          </div>
          <nav class="social">
            <a href="#" class="item">
              <img src="/images/blank.gif" alt="" class="i-social_small i-social_facebook dark">
            </a>
            <a href="#" class="item">
              <img src="/images/blank.gif" alt="" class="i-social_small i-social_twitter dark">
            </a>
            <a href="#" class="item">
              <img src="/images/blank.gif" alt="" class="i-social_small i-social_vkontakte dark">
            </a>
          </nav>
        </div>
      </div>
    </div>
    
    <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
    </span>
  </div>
</div>