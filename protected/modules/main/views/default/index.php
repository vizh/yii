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
      <div class="line"></div>
      <span class="backing">
        <a href="#" class="item">
          <img src="/images/blank.gif" alt="" class="i-social_small i-social_facebook">
          Facebook
        </a>
      </span>
      <span class="backing">
        <a href="#" class="item">
          <img src="/images/blank.gif" alt="" class="i-social_small i-social_twitter">
          Twitter
        </a>
      </span>
      <span class="backing">
        <a href="#" class="item">
          <img src="/images/blank.gif" alt="" class="i-social_small i-social_vkontakte">
          Вконтакте
        </a>
      </span>
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
              <p><i class="icon-briefcase"></i>Актуальные вакансии от компаний Рунета</p>
              <p><i class="icon-file"></i>Свежие новости</p>
              <p><i class="icon-check"></i>Профессиональные тесты/центр компетенций</p>
              <p><i class="icon-globe"></i>Все об интернете в одном месте</p>
              <div class="login">
                <a href="#">Войти / Зарегистрироваться</a>
              </div>
            </div>
          </div>
          <div id="promo-tab_orgs" class="tab tab_orgs">
            <div>
              Got contents, bro?
            </div>
          </div>
        </div>
      </div>
      <div id="promo-slider" class="b-slider span6">
        <div class="slider">
          <div class="slides">
            <div class="slide">
              <div class="content">
                <h3>Отрыв башки</h3>
                <p>Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента. Связь посредством Skype до&nbsp;последнего являлась полностью конфиденциальной и&nbsp;защищённой&nbsp;&mdash; именно поэтому. Посредством Skype до&nbsp;последнего являлась полностью конфиденциальной и&nbsp;защищённой&nbsp;&mdash; именно поэтому. </p>
              </div>
            </div>
            <div class="slide">
              <div class="content">
                <blockquote>Вы много слышали о seo, контексте и других видах онлайн-рекламы? Или немного, но этого хватило, чтобы всерьез заинтересовать Вас? Или немного, но этого хватило, чтобы всерьез заинтересовать Вас?<small>Сергеев Петр</small></blockquote>
              </div>
            </div>
            <div class="slide">
              <a href="#"><img src="/images/content/promo-banner.jpg" alt=""></a>
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

<div class="b-competences">
  <div class="container">
    <h2 class="b-header_large medium">
      <div class="line"></div>
      <div class="container">
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text">Компетенции</span>
        </div>
        <span class="backing url">
          <a href="/competences-list.html">Тесты</a>
        </span>
      </div>
    </h2>
    <div class="row units">
      <div class="competence unit span6">
        <header class="clearfix">
          <img src="/images/icon-competence-large.png" alt="" class="i-competence_large pull-left">
          <h4 class="title">Тест для SMM-специалистов</h4>
        </header>
        <article>
          <p>Умные люди давно поняли: общение в&nbsp;социальных сетях&nbsp;&mdash; это не&nbsp;только интересно, но&nbsp;и&nbsp;полезно. А&nbsp;мудрые поняли, что полезно оно может быть не&nbsp;только для них, но&nbsp;и&nbsp;для их&nbsp;компаний, бизнеса или проекта. Поняли и&nbsp;решили заниматься этим профессионально.</p>
        </article>
        <footer>
          <a href="#">
            <i class="icon-edit"></i>Пройти тест
          </a>
        </footer>
      </div
      ><div class="competence unit span6">
        <header class="clearfix">
          <img src="/images/icon-competence-large.png" alt="" class="i-competence_large pull-left">
          <h4 class="title">Игровой продюсер</h4>
        </header>
        <article>
          <p>Вы много слышали о seo, контексте и других видах онлайн-рекламы? Или немного, но этого хватило, чтобы всерьез заинтересовать Вас? Вы хотите заниматься продвижением в Интернете, но не знаете с чего начать? Вы хотите заниматься.</p>
        </article>
        <footer>
          <a href="#">
            <i class="icon-edit"></i>Пройти тест
          </a>
        </footer>
      </div
      ><div class="competence unit span6">
        <header class="clearfix">
          <img src="/images/icon-competence-large.png" alt="" class="i-competence_large pull-left">
          <h4 class="title">Тест на высшего пользователя по онлайн-рекламе</h4>
        </header>
        <article>
          <p>Чем старше становимся мы, тем интереснее становятся наши игрушки. Мальчики начинают коллекционировать уже настоящие машины, девочки – мальчиков, а большая мечта едва ли не каждого геймера – стать игровым продюсером. Пройдите этот тест, разработанный агентством интернет-рекрутинга PRUFFI.</p>
        </article>
        <footer>
          <a href="#">
            <i class="icon-edit"></i>Пройти тест
          </a>
        </footer>
      </div
      ><div class="competence unit span6">
        <header class="clearfix">
          <img src="/images/icon-competence-large.png" alt="" class="i-competence_large pull-left">
          <h4 class="title">Тест для PR-специалистов</h4>
        </header>
        <article>
          <p>PR в Рунете – больше, чем PR! И если Вас заинтересовал этот тест, Вы наверняка понимаете это как никто другой. Однако не спешите массово спамить своим резюме HR-отделы всех известных и интересных Вам компаний. Для начала пройдите этот тест, составленный специально.</p>
        </article>
        <footer>
          <a href="#">
            <i class="icon-edit"></i>Пройти тест
          </a>
        </footer>
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
          <a href="/jobs-list.html">Все вакансии</a>
        </span>
      </div>
    </h2>
    <div class="row units">
      <div class="job unit span3">
        <div class="details">
          <span class="label label-warning">5 сентября</span>
          <a href="#" class="employer">Mail.ru</a>
          <span class="fade-rtl"></span>
        </div>
        <header>
          <h4 class="title">
            <a href="#">Креативный директор в&nbsp;digital-агентство</a>
          </h4>
        </header>
        <article>
          <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital. Обязательно до&nbsp;этапа собеседования...</p>
          <a href="#">Ответить на вакансию</a>
        </article>
        <footer class="salary">
          <span>от</span>
          <strong>200&nbsp;000</strong>
          <span>Р</span>
        </footer>
        <div class="category">
          <a href="#">Бухгалтерия, экономика</a>
        </div>
      </div
      ><div class="job unit span3">
        <div class="details">
          <span class="label label-warning">10 августа</span>
          <a href="#" class="employer">Российский видеохостинг ООО &laquo;Рутюб&raquo;</a>
          <span class="fade-rtl"></span>
        </div>
        <header>
          <h4 class="title">
            <a href="#">Креативный директор в&nbsp;digital-агентство</a>
          </h4>
        </header>
        <article>
          <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital. Обязательно до&nbsp;этапа собеседования...</p>
          <a href="#">Ответить на вакансию</a>
        </article>
        <footer class="salary">
          <span>от</span>
          <strong>60&nbsp;000</strong>
          <span>Р</span>
        </footer>
        <div class="category">
          <a href="#">IT, телекоммуникации</a>
        </div>
      </div
      ><div class="job unit span3">
        <div class="details">
          <span class="label label-warning">11 июня</span>
          <a href="#" class="employer">Playboy</a>
          <span class="fade-rtl"></span>
        </div>
        <header>
          <h4 class="title">
            <a href="#">Креативный директор в&nbsp;digital-агентство</a>
          </h4>
        </header>
        <article>
          <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital. Обязательно до&nbsp;этапа собеседования...</p>
          <a href="#">Ответить на вакансию</a>
        </article>
        <footer class="salary">
          <span>от</span>
          <strong>150&nbsp;000</strong>
          <span>Р</span>
        </footer>
        <div class="category">
          <a href="#">Маркетинг, реклама, PR</a>
        </div>
      </div
      ><div class="job unit span3">
        <div class="details">
          <span class="label label-warning">28 мая</span>
          <a href="#" class="employer">Mail.ru</a>
          <span class="fade-rtl"></span>
        </div>
        <header>
          <h4 class="title">
            <a href="#">Креативный директор в&nbsp;digital-агентство</a>
          </h4>
        </header>
        <article>
          <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital. Обязательно до&nbsp;этапа собеседования...</p>
          <a href="#">Ответить на вакансию</a>
        </article>
        <footer class="salary">
          <span>от</span>
          <strong>95&nbsp;000</strong>
          <span>Р</span>
        </footer>
        <div class="category">
          <a href="#">СМИ, издательства</a>
        </div>
      </div>
    </div>
  </div>
</div>