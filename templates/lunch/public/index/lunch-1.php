<div class="lunch-container">
<h1>Вы попали на бизнес-ланч</h1>
  <div class="lunch-player">
    <iframe width="672" height="372" src="http://www.youtube.com/embed/vqauzCXHuok?rel=0" frameborder="0" allowfullscreen></iframe>
    <!-- end lunch-player -->
  </div>
  <div class="lunch-partners">
    <h3>Стратегический партнер</h3>
    <a target="_blank" href="http://www.livesignal.ru/" title="Live signal"><img src="/images/lunch/livesignal.gif" width="144" height="54" alt="Live signal" /></a>
    <h3>Партнеры</h3>
    <a target="_blank" href="http://www.nordic.me/" title="Nordic"><img src="/images/lunch/nordic.gif" width="76" height="76" alt="Nordic"  /></a>
    <a target="_blank" href="http://wedmedia.ru/" title="WedMedia"><img src="/images/lunch/wedmedia.jpg" width="76" height="76" alt="WedMedia" /></a>

    <!-- end lunch-partners -->
  </div>
  <div class="clear"></div>

  <div class="lunch-left-container">
    <div class="lunch-titles">
      <h3>Титры</h3>
      <p><span>Ведущий</span>Антон Меркуров</p>
      <p><span>Автор идеи и продюсер</span>Дмитрий Чистов</p>
      <p><span>Производство</span>Internet Media Holding</p>
      <p><span>Видеосъемка и прямой эфир </span>Live Signal</p>
      <p><span>Студия</span>Галерея Hyundai</p>
      <!-- end lunch-titles -->
    </div>
    <div class="lunch-archive">
      <h3>Свежий выпуск</h3>
      <p>
        <a href="<?=RouteRegistry::GetUrl('lunch', '', 'index', array('lunchId' => 2));?>">Бизнес-Ланч c Фёдором Вириным</a><br>
        2 декабря 2011 года
      </p>
    </div>
  </div>

  <div class="lunch-menu">

    <h3>Сегодня в меню<span>Пятница, 25 ноября 11:00 (мск)</span></h3>
    <div class="clear"></div>
    <p>1. СМИ о чём-то большем с Денисом Тереховым, агентство "Социальные Сети"</p>
    <p>2. Илья Дронов, руководитель LiveJournal</p>
    <p>3. "Премия Рунета" и итоги 2011 года</p>
    <p>4. Авинаш Кошик, digital marketing evangelist компании Google, об интернет-маркетинге и его измерении</p>


    <div class="b-share">
      <div class="b-share-tweet">
        <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-url="<?=$this->Url;?>">Tweet</a>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
      </div>
      <div class="b-share-facebook">
        <script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script>
        <fb:like href="<?=$this->Url;?>" layout="button_count" show_faces="false" width="100" font=""></fb:like>
      </div>
      <div class="clear"></div>
    </div>

    <!-- end lunch-menu -->
  </div>

  <div class="clear"></div>

  <?php echo $this->Comments;?>


  <!-- end lunch-container -->
</div>
<div class="clear"></div>