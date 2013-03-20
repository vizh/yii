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
      <div id="promo-tabs" class="b-tabs span6">
        <div>
          <ul class="nav clearfix">
            <li><a href="#promo-tab_users">Пользователям</a></li>
            <li><a href="#promo-tab_orgs">Организаторам</a></li>
          </ul>
          <div id="promo-tab_users" class="tab tab_users">
            <div>
              <p><i class="icon-calendar"></i>Главные мероприятия Рунета</p>
              <p><i class="icon-briefcase"></i>Актуальные вакансии интернет-отрасли</p>
              <p><i class="icon-file"></i>Свежие новости</p>
              <p><i class="icon-check"></i>Профессиональные тесты/центр компетенций</p>
              <p><i class="icon-globe"></i>Скидки на партнерские мероприятия</p>
              <div class="login">
                <?if (Yii::app()->user->getCurrentUser() === null):?>
                  <a id="PromoLogin" href="#">Войти / Зарегистрироваться</a>
                <?else:?>
                   <?=Yii::app()->user->getCurrentUser()->FirstName;?>, мы рады что вы с нами!
                <?endif;?>
              </div>
            </div>
          </div>
          <div id="promo-tab_orgs" class="tab tab_orgs">
            <div>
              <p><i class="icon-globe"></i>Подробный профиль компании</p>
              <p><i class="icon-calendar"></i>Размещение событий в календаре мероприятий</p>
              <p><i class="icon-briefcase"></i>Продажа билетов на мероприятия</p>
              <p><i class="icon-check"></i>Регистрация на мероприятие «в один клик»</p>
              <p><i class="icon-file"></i>Эффективные инструменты рекламных кампаний</p>
              <div class="login">
                <a href="<?=Yii::app()->createUrl('/event/list/index');?>">Мероприятия</a>, которые уже сотрудничают с нами
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="promo-slider" class="b-slider span6">
        <div class="slider">
          <div class="slides">
            <div class="slide">
              <a href="http://rif.ru/" target="_blank"><img src="/images/content/promo-banners/2013-04-rif13.jpg" alt="РИФ+КИБ 2013"></a>
            </div>
            <div class="slide">
              <div class="content">
                <h3>Для интернет-пользователей</h3>
                <p>Он объединяет в себе удобную систему регистрации на мероприятия медиа- и интернет-индустрии, а также позволяет всем участникам системы записывать в историю профессиональный опыт и отображать компетенции в различных сферах. Сервис будет удобен специалистам для реализации своих идей и проектов.</p>
              </div>
            </div>
            <div class="slide">
              <div class="content">
                <h3>Сервис для компаний</h3>
                <p>Если вы организуете конференции, семинары, вебинары, форумы, премии или иные мероприятия медиа- и интернет-направленности, сервис позволяет открыть мероприятие и сообщить об этом целевой аудитории. Для привлечения аудитории мы предлагаем как внутренние ресурсы системы, так и задействуем внешние источники (контекстная реклама, работа с пользователями социальных сетей, реклама в СМИ, рекламно-информационная продукция).</p>
              </div>
            </div>
          </div>
        </div>
        <i id="promo-slider_prev" class="icon-chevron-left"></i>
        <i id="promo-slider_next" class="icon-chevron-right"></i>
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
          <img src="<?=$event->getLogo()->getSquare70();?>" width="70" height="70" alt="" class="logo img-circle">
          <?=$this->renderPartial('index/event-dates', array('event' => $event));?>
          <header>
            <h4 class="title">
              <a href="<?=Yii::app()->createUrl('/event/view/index', array('idName' => $event->IdName));?>"><?=$event->Title;?></a>
            </h4>
          </header>
          <article>
            <p><?=$event->Info;?></p>
            <a href="/event-page.html">...</a>
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
            <p><?=$job->getPreview();?></p>
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