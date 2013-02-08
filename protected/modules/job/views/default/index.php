<section id="section" role="main">
    <h2 class="b-header_large light">
      <div class="line"></div>
      <div class="container">
        <div class="title">
          <span class="backing runet">Runet</span>
          <span class="backing text">Работа</span>
        </div>
      </div>
    </h2>

    <div class="container">
      <?=\CHtml::form('', 'GET', array('class' => 'form-inline form-filter span12'));?>
        <?php $categories = $filter->getCategoryList();?>
        <?=\CHtml::activeDropDownList($filter, 'CategoryId', $categories, array('class' => 'span3 form-element_select form-filter_category'));?>
        <?foreach($categories as $id => $title):?>
          <?=\CHtml::activeDropDownList($filter, 'PositionId', $filter->getPositionList($id), array('class' => 'span3 form-element_select hide form-filter_position', 'data-category' => $id));?>
        <?endforeach;?>
        <div class="dropdown form-filter_salary">
          От <a class="dropdown-toggle" href="#"><?=$filter->SalaryFrom;?></a><?=\CHtml::activeTextField($filter, 'SalaryFrom', array('class' => 'span1 hide'));?> Р
        </div>
        <div class="pull-right">
          <?=\CHtml::activeTextField($filter, 'Query', array('class' => 'span3', 'placeholder' => \Yii::t('app', 'Поиск')));?>
          <?=\CHtml::imageButton('/images/search-type-image-light.png', array('class' => 'form-element_image', 'width' => 20, 'height' => 19));?>
        </div>
      <?=\CHtml::endForm();?>
    </div>

    <div class="b-jobs">
      <div class="container">
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

      <div class="job_promo">
        <div class="bg"></div>
        <div class="container">
          <div class="job">
            <div class="details">
              <span class="label label-warning">11 июня</span>
              <div class="employer-row">
                <a href="#" class="employer">
                  <img src="/images/content/employer-logo-playboy.png" width="20" height="30" alt="" class="logo">Playboy
                </a>
              </div>
            </div>
            <header>
              <h2 class="title">
                <a href="#">Креативный директор в&nbsp;digital-агентство</a>
              </h2>
            </header>
            <article>
              <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital. Обязательно до&nbsp;этапа собеседования...</p>
              <a href="#">Ответить на вакансию</a>
            </article>
            <div class="row">
              <div class="span4 offset4">
                <footer class="salary">
                  <span>от</span>
                  <strong>150&nbsp;000</strong>
                  <span>$</span>
                </footer>
              </div>
            </div>
            <div class="category">
              <a href="#">Маркетинг, реклама, PR</a>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
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
              <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital...</p>
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
              <p>Известное digital агентство ищет креативного директора. Нужно: &laquo;отрыв башки&raquo;, абсолютная безбашенность при этом четкое соблюдение сроков и&nbsp;понимание клиента, обязателен большой опыт работы именно digital...</p>
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
          </div
          ><div class="job unit span3">
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

    <!--#include virtual="_pagination.html" -->
  </section>
