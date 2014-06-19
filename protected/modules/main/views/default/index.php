<?php
/**
 * @var $events \event\models\Event[]
 * @var $this DefaultController
 */
?>

<div id="promo" class="b-promo">
  <div class="container">
    <img src="/images/logo-large.png" width="448" height="41" alt="-RUNET-ID-" class="logo">
    <nav class="b-social">

    </nav>
    <div class="row">
      <div class="span6 create-event-banner">
        <div>
          <h3>Если есть событие в Рунете &mdash;<br>вы найдете его у нас</h3>
          <p>Создайте свое мероприятие<br>и&nbsp;начните продавать билеты<br>прямо сейчас</p>
          <a class="btn btn-large btn-success reachGoal" data-goal="BANNER_MAINPAGE_CREATE-EVENT" href="<?=Yii::app()->createUrl('/page/info/features')?>"><i class="icon-white icon-ok-sign"></i> Создать мероприятие</a>
        </div>
      </div>
      <div class="span6 request-registration-banner">
        <div>
          <h3>Если нужна регистрация<br>участников на месте</h3>
          <p>Офлайн регистрация участников<br>любой сложности<br>по справедливой стоимости</p>
          <a class="btn btn-large btn-info reachGoal" data-goal="BANNER_MAINPAGE_REQUEST-REGISTRATION" href="http://bit.ly/1hcOyaG" target="_blank"><i class="icon-white icon-ok-sign"></i> Заказать регистрацию</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="b-events">
  <div class="container">
    <h2 class="b-header_large dark">
      <div class="line"></div>
      <div class="container">
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text">Мероприятия</span>
        </div>
        <span class="backing url">
          <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Все мероприятия</a>
        </span>
      </div>
    </h2>
    <div class="row">

      <?foreach ($events as $event):?>
        <div class="event span4">
          <div class="logo-box">
            <div class="white">
              <a href="<?=Yii::app()->createUrl('/event/view/index', array('idName' => $event->IdName));?>" class="reachGoal" data-goal="BANNER_MAINPAGE_EVENTS"><img src="<?=$event->getLogo()->getSquare70();?>" width="70" height="70" alt="" class="logo"></a>
            </div>
          </div>
          <?=$this->renderPartial('index/event-dates', array('event' => $event));?>
          <header>
            <h4 class="title">
              <a href="<?=Yii::app()->createUrl('/event/view/index', array('idName' => $event->IdName));?>" class="reachGoal" data-goal="BANNER_MAINPAGE_EVENTS"><?=$event->Title;?></a>
            </h4>
          </header>
          <article>
            <p><?=$event->Info;?></p>
            <a href="<?=Yii::app()->createUrl('/event/view/index', array('idName' => $event->IdName));?>" class="reachGoal" data-goal="BANNER_MAINPAGE_EVENTS">...</a>
          </article>
          <footer>
            <img src="/images/blank.gif" alt="" class="i-event_small <?=$event->Type->CssClass;?>">
          </footer>
        </div>
      <?endforeach;?>
    </div>
  </div>
</div>

<?php $this->widget('\application\widgets\News', array('limit' => 3));?>

<div class="b-competences" id="competences">
  <div class="container">
    <h2 class="b-header_large medium">
      <div class="line"></div>
      <div class="container">
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text">Компетенции</span>
        </div>
      </div>
    </h2>
    <div class="row">
      <div class="span6">
        <article>
          <p>Центр компетенций&nbsp;&mdash; это проект RUNET-ID в&nbsp;сфере профессиональной ориентации пользвоателей&nbsp;Рунета. В&nbsp;скором времени будут доступны более 30 тестов по&nbsp;разным направлениям в&nbsp;области интернет-технологий.</p>
        </article>
      </div>
      <div class="span6">
        <article>
          <p>По&nbsp;итогам прохождения тестирования Вам будет присвоен балл и&nbsp;выданы рекомендации по&nbsp;повышению профессиональной деятельности (от&nbsp;литературы, курсов и&nbsp;учебных&nbsp;заведений).</p>
        </article>
      </div>
    </div>
  </div>
</div>

<div class="b-jobs">
  <div class="container">
    <h2 class="b-header_large light">
      <div class="line"></div>
      <div class="container">
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text">Работа</span>
        </div>
        <span class="backing url">
          <a href="<?=$this->createUrl('/job/default/index');?>">Все вакансии</a>
        </span>
      </div>
    </h2>
    <div class="row units">
      <?foreach($jobs as $job):?>
        <div class="job span3">
          <div class="details">
            <span class="label label-warning"><?=\Yii::app()->dateFormatter->format('dd MMMM', $job->CreationTime);?></span>
            <span class="employer"><?=$job->Company->Name;?></span>
            <span class="fade-rtl"></span>
          </div>
          <header>
            <h4 class="title">
              <a target="_blank" href="<?=$job->Url;?>"><?=$job->Title;?></a>
            </h4>
          </header>
          <article>
            <p><?=\application\components\utility\Texts::cropText($job->Text, \Yii::app()->params['JobPreviewLength']);?></p>
            <a target="_blank" href="<?=$job->Url;?>"><?=\Yii::t('app', 'Ответить на вакансию');?></a>
          </article>
          <footer class="salary">
            <?=$this->renderPartial('job.views.default.job-salary', array('job' => $job));?>
          </footer>
          <div class="category">
            <a href="<?=$this->createUrl('/job/default/index', array('Filter[CategoryId]' => $job->CategoryId));?>"><?=$job->Category->Title;?></a>
          </div>
        </div>
      <?endforeach;?>
    </div>
  </div>
</div>