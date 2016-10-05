<section id="section" role="main">
  <div class="announcement">
    <div class="container">
      <img src="/modules<?=$this->layout?>/images/lev-tolstoy.png" alt="" class="lev-tolstoy">
      <div class='logo-announcement'>
        <img src="/modules<?=$this->layout?>/images/logo-announcement.png" alt="">
      </div>
      <div class="datetime">
        <div>
          <span class="day">9, 10</span>
          <span class="month">декабря</span>
          <span class="year">2012</span>
        </div>
      </div>
      <ul class="details">
        <li class="detail"><span>Признанные гуру интернет-бизнеса и дерзкие новички</span></li>
        <li class="detail"><span>Противостояние бизнес-моделей и платформ</span></li>
        <li class="detail"><span>Стартап-аллея и запуск новых продуктов</span></li>
      </ul>
    </div>
  </div>

  <div class='container'>
    <?=CHtml::beginForm('', 'POST', array('class' => 'event-registration'))?>
      <header>
        <h3 class="title">Регистрация</h3>
      </header>


      <?foreach($products as $product):?>
        <article>
          <h4 class="article-title"><?=$product->Title?></h4>
          <p><?=$product->Description?></p>
        </article>

        <table class="table table-condensed">
          <thead>
            <tr>
              <th></th>
              <th class="t-right">Цена</th>
              <th class="t-center">Кол-во</th>
              <th class="t-right">Сумма</th>
            </tr>
          </thead>
          <tbody>
            <?foreach($product->Prices as $price):?>
              <?$dateFormatter = \Yii::app()->dateFormatter?>

              <tr data-price="<?=$price->Price?>">
                <?if($price->StartTime < date('Y-m-d') && $price->EndTime >= date('Y-m-d')):?>
                  <td><strong>При регистрации до <?=$dateFormatter->format('dd MMMM', $price->EndTime)?></strong></td>
                <?php elseif ($price->StartTime >= date('Y-m-d') && $price->EndTime >= date('Y-m-d')):?>
                  <td><strong>При регистрации c <?=$dateFormatter->format('dd MMMM', $price->StartTime)?> до <?=$dateFormatter->format('dd MMMM', $price->EndTime)?></strong></td>
                <?else:?>
                  <td><strong>При регистрации до <?=$dateFormatter->format('dd MMMM', $price->StartTime)?> и на входе</strong></td>
                <?endif?>
                <td class="t-right price"><strong><?=$price->Price?></strong> руб.</td>
                <td class="t-center">
                  <?=CHtml::activeDropDownList($orderForm, 'Count['.$product->ProductId.']', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini'))?>
                </td>
                <td class="t-right totalPrice"><strong>0</strong> руб.</td>
              </tr>
            <?endforeach?>
          </tbody>
        </table>
      <?endforeach?>

      <div class="t-right total">
        <span>Итого:</span><strong id='grandTotal'>0</strong> руб.
      </div>

      <div class="t-center">
        <button class="btn btn-large btn-success">Зарегистрироваться</button>
      </div>

    <?=CHtml::endForm()?>
  </div>

  <div class="container">

    <nav class="content-nav t-center">
      <a href="javascript: void(null);" class="current">Полное описание</a>
      <span>/</span>
      <a href="javascript: void(null);">Программа мероприятия</a>
    </nav>

    <div class="row">
      <article class="span10 offset1 content">
        <header>
          <p>Международная IT-конференция техноблога TechCrunch посвящена анализу новых стартапов, обзору Интернет-проектов и&nbsp;публикации горячих новостей из&nbsp;сферы технологий. C&nbsp;2010 года TechCrunch Moscow представляет миру все самое интересное, что происходит на&nbsp;технологических рынках России.</p>
        </header>
        <blockquote>В 2012 году TechCrunch Moscow организован центром технологий и технологического предпринимательства Digital October и венчурным фондом Kite Ventures совместно с AOL Media и TechCrunch Europe, при поддержке РАЭК. Участников конференции ожидают два дня, насыщенные интервью, дискуссиями и питчами стартапов.</blockquote>
        <ul>
          <li>Программа <b>TechCrunch Moscow 2012 формируется вокруг темы &laquo;Войны и&nbsp;мира&raquo;&nbsp;</b>&mdash; противостояния бизнес-моделей, стратегий, технологий, а&nbsp;также появления новых рынков, компаний и&nbsp;лидеров.</li>
          <li>Ожидается <b>более 30&nbsp;выступающих и&nbsp;около 900&nbsp;участников</b>, среди которых технологические предприниматели, венчурные инвесторы, представители крупных IT-компаний и&nbsp;медиа из&nbsp;России, Европы и&nbsp;США. Свое участие уже подтвердили Брент Хоберман (серийный предприниматель, основатель Lastminute.com и&nbsp;Mydeco.com), Лукаш Гадовски (основатель фонда Team Europe), Степан Пачиков (основатель Paragraph и&nbsp;Evernote), представители EBRD, Bessemer Venture Partners и&nbsp;другие.</li>
          <li>В&nbsp;качестве ведущих TechCrunch Moscow 2011 выступят <b>Майк Бутчер</b> (главный редактор TechCrunch Europe) и&nbsp;<b>Нед Дезмонд</b> (предприниматель в&nbsp;сфере новых медиа, главный управляющий AOL Tech Media).</li>
          <li>Demo Day и&nbsp;Аллея стартапов соберут <b>перспективные стартапы</b>, готовые к&nbsp;общению с&nbsp;международными инвесторами. Финалисты демо-дня примут участие в&nbsp;традиционной Битве стартапов, завершающей конференцию.</li>
          <li>В&nbsp;новой мультимедийной аудитории Digital October будет организована площадка Launchpad, на&nbsp;которой <b>основатели стартапов будут объявлять о&nbsp;запуске новых компаний или продуктов</b>.</li>
          <li>К&nbsp;участникам конференции присоединятся делегации от&nbsp;<b>Founders Forum</b> (конференция основателей технологических стартапов, которая проводится в&nbsp;Лондоне и&nbsp;Нью-Йорке) и&nbsp;<b>CEO Forum</b> (конференция CEO технологических компаний, проводится в&nbsp;Берлине).</li>
        </ul>
      </article>
    </div>

    <div class="container follow-news clearfix">
      <div class="row">
        <div class="span6 pull-left t-right">Следите<br>за новостями</div>
        <div class="span6 pull-right t-left">
          <a href="http://tc.digitaloctober.ru">http://tc.digitaloctober.ru</a>
          <br>
          <a href="http://www.facebook.com/digitaloctober">http://www.facebook.com/digitaloctober</a>
        </div>
      </div>
    </div>

  </div>

  <div class="contacts">
    <header>
      <h3 class="title">Контакты</h3>
    </header>
    <article>
      <span class="phone">+7(495)988–33–56</span>
      <span class="phone">+7(985)766–19–25</span>
      <a href="mailto: DO@digitaloctober.com" class="email">DO@digitaloctober.com</a>
    </article>
  </div>

  <div class="map">
    <nav class="t-center">
      <a href="javascript: void(null);" class="map-road" id="kropotkinskaya">От метро «Кропоткинская»</a>
      <a href="javascript: void(null);" class="map-road" id="polyanka">От метро «Полянка»</a>
      <a href="javascript: void(null);" class="map-road" id="tretyakovskaya">От метро «Третьяковская»</a>
    </nav>
    <div id="map"></div>
  </div>

  <div class="container partners">
    <header>
      <h3 class="title"><span>Партнёры</span></h3>
    </header>
    <article>
      <a href="#"><img src="/modules<?=$this->layout?>/images/partners/tech-crunch.png" alt="" class="partner"></a>
      <a href="#"><img src="/modules<?=$this->layout?>/images/partners/kite-ventures.png" alt="" class="partner"></a>
      <a href="#"><img src="/modules<?=$this->layout?>/images/partners/digital-october.png" alt="" class="partner"></a>
    </article>
  </div>
</section>