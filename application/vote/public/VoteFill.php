<?php
AutoLoader::Import('vote.source.*');

class VoteFill extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    //$this->fill();

    //$this->showResult(1);

  }

  protected function fill()
  {
    /*** STEP 1 **********************************************************************/

    $question = $this->addQuestion('Приходилось ли Вам когда-нибудь зарабатывать (получать доход) в Интернет с помощью веб-сайтов?', 1, 'SingleQuestionType');

    $this->addAnswer($question, 'Да. В прошлом я получал(а) доход с помощью веб-сайта.');
    $answer1_2 = $this->addAnswer($question, 'Да. Я получаю доход с помощью веб-сайта в настоящее время.');
    $this->addAnswer($question, 'Нет');

    $question = $this->addQuestion('Сколько Вам лет?', 1, 'SingleQuestionType');
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'младше 18');
    $this->addAnswer($question, '18-24');
    $this->addAnswer($question, '25-34');
    $this->addAnswer($question, '35-44');
    $this->addAnswer($question, '45 и старше');

    $question = $this->addQuestion('Сколькими сайтами Вы владеете?', 1, 'SingleQuestionType', '',0);
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, '1 веб-сайт');
    $this->addAnswer($question, '2-5 веб-сайтов');
    $this->addAnswer($question, '5-10 веб-сайтов');
    $this->addAnswer($question, 'Более 10 веб-сайтов');
    $this->addAnswer($question, 'Более 50 веб-сайтов');
    $this->addAnswer($question, 'Более 100 веб-сайтов');

    $question = $this->addQuestion('Ежедневная посещаемость сайта', 1, 'SingleQuestionType', 'Если у Вас несколько веб-сайтов, то выберите наиболее крупный из них или используйте среднестатистические данные ваших веб-ресурсов.');
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'до 100 посетителей в день');
    $this->addAnswer($question, '100 - 300 посетителей в день');
    $this->addAnswer($question, '300 - 1 000 посетителей в день');
    $this->addAnswer($question, '1 тыс - 5 тыс. посетителей в день');
    $this->addAnswer($question, '5 тыс. - 10 тыс. посетителей в день');
    $this->addAnswer($question, '10 тыс. - 50 тыс. посетителей в день');
    $this->addAnswer($question, 'более 50 тыс. посетителей в день');

    $question = $this->addQuestion('Тематический сегмент сайта', 1, 'SingleQuestionType', 'Если у Вас несколько веб-сайтов, то выберите наиболее крупный из них или используйте среднестатистические данные ваших веб-ресурсов.');
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'Развлекательные сайты');
    $this->addAnswer($question, 'Новостные сайты');
    $this->addAnswer($question, 'Тематический контент-ресурс');
    $this->addAnswer($question, 'Коммьюнити (социальная сеть, форум, коллективный блог и т.д)');
    $this->addAnswer($question, 'Персональный сайт/блог');
    $this->addAnswer($question, 'Онлайн-сервис');
    $this->addAnswer($question, 'Коммерческий сайт (сайт компании, интернет-магазин)');

    $question = $this->addQuestion('Доход с веб-сайта (ов) - это', 1, 'SingleQuestionType');
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'Основной доход');
    $this->addAnswer($question, 'Дополнительный доход');
    $this->addAnswer($question, 'Просто хобби');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие модели монетизации веб-проектов Вы используете?', 1, 'MultipleQuestionType');
    $question->AddDepend($answer1_2);

    $answer7_1 = $this->addAnswer($question, 'Рекламная модель (Доход от размещения баннеров, тизеров, рекламных статей или ссылок)');
    $this->addAnswer($question, 'Сервисная модель (Доход от продажи онлайн-услуг: доступ к базе резюме, платная веб-почта и т.д.)');
    $this->addAnswer($question, 'Коммерческая модель (Доход от продажи товаров/услуг, в том числе цифровых товаров)');


    $question = $this->addQuestion('Как зарабатываете на рекламе?', 1, 'MultipleQuestionType');
    $question->AddDepend($answer7_1);

    $answer8_1 = $this->addAnswer($question, 'Продажа рекламы с оплатой за показы (CPM/P4P)');
    $answer8_2 = $this->addAnswer($question, 'Продажа рекламы с оплатой за клики/переходы (CPC/PPC)');
    $answer8_3 = $this->addAnswer($question, 'Продажа рекламы с оплатой за действия (CPA/CPL/CPS)');
    $answer8_4 = $this->addAnswer($question, 'Продажа SEO ссылок/статей');

    /**** STEP 2 *********************************************************************************/

    $question = $this->addQuestion('Почему отказались от рекламы с оплатой за показы?', 2, 'MultipleQuestionType');
    $question->AddDepend($answer1_2);
    $question->AddDepend($answer8_1, true);

    $this->addAnswer($question, 'Не устраивает потенциальный доход');
    $this->addAnswer($question, 'Не достаточная посещаемость веб-сайта(ов)');
    $this->addAnswer($question, 'Тематика веб-сайта(ов) не подходит');
    $this->addAnswer($question, 'Нет качественной рекламы');
    $this->addAnswer($question, 'Пока не использовал');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Почему выбрали рекламу с оплатой за показы?', 2, 'MultipleQuestionType');
    $question->AddDepend($answer8_1);

    $this->addAnswer($question, 'Потенциальный доход');
    $this->addAnswer($question, 'Прогнозируемость дохода');
    $this->addAnswer($question, 'Минимальный риск со стороны владельца веб-ресурса');
    $this->addAnswer($question, 'Простота работы/интеграции');
    $this->addAnswer($question, 'Другое: ', 1);

    $question = $this->addQuestion('Какие каналы размещения используете?', 2, 'MultipleQuestionType');
    $question->AddDepend($answer8_1);

    $answer11_1 = $this->addAnswer($question, 'Прямые продажи рекламодателям');
    $this->addAnswer($question, 'Рекламные агентства');
    $answer11_3 = $this->addAnswer($question, 'Рекламные сети');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какую систему управления рекламой используете?', 2, 'SingleQuestionType');
    $question->AddDepend($answer11_1);

    $this->addAnswer($question, 'Собственная разработка');
    $this->addAnswer($question, 'Модуль/плагин CMS');
    $this->addAnswer($question, 'Бесплатная система управления рекламой (например: OpenX)');
    $this->addAnswer($question, 'Платная система управления рекламой');
    $this->addAnswer($question, 'DFP (DoubleClick for Publishers)');
    $this->addAnswer($question, 'Adriver');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие рекламные сети используете?', 2, 'MultipleQuestionType');
    $question->AddDepend($answer11_3);

    $this->addAnswer($question, 'Соловей (soloway.ru)');
    $this->addAnswer($question, 'Каванга (kavanga.ru)');
    $this->addAnswer($question, 'RLE (rle.ru)');
    $this->addAnswer($question, 'TBN (tbn.ru)');
    $this->addAnswer($question, 'RORER (rorer.ru)');
    $this->addAnswer($question, 'Rotaban (rotaban.ru)');
    $this->addAnswer($question, 'Другое: ', 1);

    $question = $this->addQuestion('Оцените рекламные системы', 2, 'CriterionQuestionType', 'Постарайтесь использовать более объективную оценку.<br>
    <strong>Доходность</strong> - потенциальная доходность сервиса или доход, который вы получаете<br>
    <strong>Качество рекламы</strong> - тематичность, релевантность рекламных материалов. Оценивайте систему в общем, а не отдельных рекламодателей.<br>
    <strong>Удобство работы</strong> - насколько сложно работать с интерфейсом системы или установить/интегрировать код системы.', 0);
    $question->AddDepend($answer11_3);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Качество рекламы', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Соловей');
    $this->addAnswer($question, 'Каванга');
    $this->addAnswer($question, 'RLE');
    $this->addAnswer($question, 'TBN');
    $this->addAnswer($question, 'RORER');
    $this->addAnswer($question, 'Rotaban');

    $question = $this->addQuestion('Укажите средний eCPM на Вашем сайте ', 2, 'InputQuestionType', '<strong>eCPM</strong> (аббревиатура от английского <i>Effectivecostpermille</i>) – эффективная/реальная стоимость за тысячу показов', 0);
    $question->AddDepend($answer8_1);

    $this->addAnswer($question, 'eCPM');


    /*****  STEP 3  ****************************/


    $question = $this->addQuestion('Почему отказались от рекламы с оплатой за клики/переходы?', 3, 'MultipleQuestionType');
    $question->AddDepend($answer1_2);
    $question->AddDepend($answer8_2, true);

    $this->addAnswer($question, 'Не устраивает потенциальный доход');
    $this->addAnswer($question, 'Не достаточная посещаемость веб-сайта(ов)');
    $this->addAnswer($question, 'Тематика веб-сайта(ов) не подходит');
    $this->addAnswer($question, 'Нет качественной рекламы');
    $this->addAnswer($question, 'Пока не использовал');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Почему выбрали рекламу с оплатой за клики/переходы', 3, 'MultipleQuestionType');
    $question->AddDepend($answer8_2);

    $this->addAnswer($question, 'Потенциальный доход');
    $this->addAnswer($question, 'Прогнозируемость дохода');
    $this->addAnswer($question, 'Простота работы/интеграции');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие каналы размещения используете?', 3, 'MultipleQuestionType');
    $question->AddDepend($answer8_2);

    $this->addAnswer($question, 'Прямые продажи (собственная рекламная система)');
    $answer18_2 = $this->addAnswer($question, 'Контекстная рекламная система (Google Adsense, Яндекс-Директ, Бегун, B2BContext)');
    $answer18_3 = $this->addAnswer($question, 'Товарные рекламные системы (Микс-Товары, Nadavi и т.д.)');
    $answer18_4 = $this->addAnswer($question, 'Тизерная рекламная сеть (Adlabs Media Network, Direct/ADVERT и т.д.)');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие контекстные рекламные системы Вы используете?', 3, 'MultipleQuestionType');
    $question->AddDepend($answer18_2);

    $this->addAnswer($question, 'Google Adsense');
    $this->addAnswer($question, 'Рекламная сеть Яндекса / Яндекс.Директ');
    $this->addAnswer($question, 'Бегун');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие системы товарной рекламы используете?', 3, 'MultipleQuestionType');
    $question->AddDepend($answer18_3);

    $this->addAnswer($question, 'Микс-Товары (Партнерская сеть Миксмаркет)');
    $this->addAnswer($question, 'Nadavi.net');
    $this->addAnswer($question, 'Яндекс.Маркет в рамках РСЯ');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие системы тизерной рекламы используете?', 3, 'MultipleQuestionType');
    $question->AddDepend($answer18_4);

    $this->addAnswer($question, 'AdLabs Media Network (medianet.adlabs.ru)');
    $this->addAnswer($question, 'AdSyst (adsyst.ru)');
    $this->addAnswer($question, 'MargetGid (marketgid.com)');
    $this->addAnswer($question, 'TeaserNet (teasernet.com)');
    $this->addAnswer($question, 'BodyClick (bodyclick.net)');
    $this->addAnswer($question, 'Direct/ADVERT (directadvert.ru): ');



    $question = $this->addQuestion('Оцените контекстные рекламные системы', 3, 'CriterionQuestionType', 'Постарайтесь использовать более объективную оценку.<br>
    <strong>Доходность</strong> - потенциальная доходность сервиса или доход, который вы получаете<br>
    <strong>Качество рекламы</strong> - тематичность, релевантность рекламных материалов. Оценивайте систему в общем, а не отдельных рекламодателей.<br>
    <strong>Удобство работы</strong> - насколько сложно работать с интерфейсом системы или установить/интегрировать код системы.', 0);
    $question->AddDepend($answer18_2);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Качество рекламы', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Google Adsense');
    $this->addAnswer($question, 'Рекламная сеть Яндекса / Яндекс.Директ');
    $this->addAnswer($question, 'Бегун');


    $question = $this->addQuestion('Оцените товарные рекламные системы', 3, 'CriterionQuestionType', '', 0);
    $question->AddDepend($answer18_3);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Качество рекламы', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Микс-Товары (Партнерская сеть Миксмаркет)');
    $this->addAnswer($question, 'Nadavi.net');
    $this->addAnswer($question, 'Яндекс.Маркет в рамках РСЯ');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Оцените системы тизерной рекламы', 3, 'CriterionQuestionType', '', 0);
    $question->AddDepend($answer18_4);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Качество рекламы', 'Удобство работы')
    ));

    $this->addAnswer($question, 'AdLabs Media Network');
    $this->addAnswer($question, 'AdSyst');
    $this->addAnswer($question, 'MargetGid');
    $this->addAnswer($question, 'TeaserNet');
    $this->addAnswer($question, 'BodyClick');
    $this->addAnswer($question, 'Direct/ADVERT');


    /*****************  STEP 4 ***********************/


    $question = $this->addQuestion('Почему отказались от рекламы с оплатой за действия?', 4, 'MultipleQuestionType');
    $question->AddDepend($answer1_2);
    $question->AddDepend($answer8_3, true);

    $this->addAnswer($question, 'Не устраивает потенциальный доход');
    $this->addAnswer($question, 'Тематика веб-сайта(ов) не подходит');
    $this->addAnswer($question, 'Нет качественной рекламы');
    $this->addAnswer($question, 'Пока не использовал');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Почему выбрали рекламу с оплатой за действия?', 4, 'MultipleQuestionType');
    $question->AddDepend($answer8_3);

    $this->addAnswer($question, 'Потенциальный доход');
    $this->addAnswer($question, 'Могу сам решать какая реклама будет на сайте');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('C какими форматами оплаты работаете?', 4, 'MultipleQuestionType');
    $question->AddDepend($answer8_3);

    $this->addAnswer($question, 'CPA (Cost Per Action) - оплата за действия: регистрация, достижение уровня в игре и т.д.');
    $this->addAnswer($question, 'CPL (Cost Per Lead) - оплата за лид: заполнение заявки/анкеты потенциальным клиентом');
    $this->addAnswer($question, 'CPO (Cost Per Order)- оплата за оформленный заказ в интернет-магазине');
    $this->addAnswer($question, 'CPS (Cost Per Sales) - оплата за выполненный заказ в интернет-магазине (заказ оплачен и доставлен потребителю)');


    $question = $this->addQuestion('Какой формат выплаты партнерского вознаграждения для Вас предпочтительнее?', 4, 'SingleQuestionType');
    $question->AddDepend($answer8_3);

    $this->addAnswer($question, 'Фиксированная сумма');
    $this->addAnswer($question, '% с продаж');


    $question = $this->addQuestion('Какие каналы размещения используете?', 4, 'MultipleQuestionType');
    $question->AddDepend($answer8_3);

    $this->addAnswer($question, 'Прямые продажи (собственная рекламная система)');
    $this->addAnswer($question, 'Работаю напрямую с партнерскими программами');
    $answer29_3 = $this->addAnswer($question, 'Работаю с агрегаторами партнерских программ / рекламными сетями');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('С какими агрегаторами партнерских программ работаете?', 4, 'MultipleQuestionType');
    $question->AddDepend($answer29_3);

    $this->addAnswer($question, 'Партнерская сеть Микмаркет (mixmarket.biz)');
    $this->addAnswer($question, 'Admitad (admitad.com)');
    $this->addAnswer($question, 'Cityads (cityads.ru)');
    $this->addAnswer($question, 'CPA Network (cpanetwork.ru)');
    $this->addAnswer($question, 'Где слон (gdeslon.ru)');
    $this->addAnswer($question, 'ActionPay (actionpay.ru)');
    $this->addAnswer($question, 'Myragon (myragon.ru)');
    $this->addAnswer($question, 'Leads (leads.su)');
    $this->addAnswer($question, 'AD1 (ad1.ru)');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Оцените агрегаторов партнерских программ', 4, 'CriterionQuestionType');
    $question->AddDepend($answer29_3);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Количество программ/ офферов', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Партнерская сеть Микмаркет (mixmarket.biz)');
    $this->addAnswer($question, 'Admitad');
    $this->addAnswer($question, 'Cityads');
    $this->addAnswer($question, 'CPA Network');
    $this->addAnswer($question, 'Где слон');
    $this->addAnswer($question, 'ActionPay');
    $this->addAnswer($question, 'Myragon');
    $this->addAnswer($question, 'Leads');
    $this->addAnswer($question, 'AD1');


    /*****************  STEP 5 ***********************/


    $question = $this->addQuestion('Почему не продаете SEO ссылки/статьи?', 5, 'MultipleQuestionType');
    $question->AddDepend($answer1_2);
    $question->AddDepend($answer8_4, true);

    $this->addAnswer($question, 'Не устраивает потенциальный доход');
    $this->addAnswer($question, 'Мешает продвижению веб-проекта в поисковых системах');
    $this->addAnswer($question, 'Нет качественной рекламы');
    $this->addAnswer($question, 'Тематика веб-сайта(ов) не подходит');
    $this->addAnswer($question, 'Пока не использовал');
    $this->addAnswer($question, 'Другое: ', 1);

    $question = $this->addQuestion('Почему не продаете SEO ссылки/статьи?', 5, 'MultipleQuestionType');
    $question->AddDepend($answer8_4);

    $this->addAnswer($question, 'Потенциальный доход');
    $this->addAnswer($question, 'Прогнозируемость дохода');
    $this->addAnswer($question, 'Простота работы/интеграции');
    $this->addAnswer($question, 'Другое: ', 1);

    $question = $this->addQuestion('Что продаете?', 5, 'MultipleQuestionType');
    $question->AddDepend($answer8_4);

    $this->addAnswer($question, 'SEO ccылки');
    $this->addAnswer($question, 'SEO статьи');


    $question = $this->addQuestion('Как продаете? ', 5, 'MultipleQuestionType');
    $question->AddDepend($answer8_4);

    $this->addAnswer($question, 'Самостоятельно через знакомых, форумы и т.д.');
    $answer35_2 = $this->addAnswer($question, 'Биржи ссылок');
    $answer35_3 = $this->addAnswer($question, 'Биржи статей');
    $answer35_4 = $this->addAnswer($question, 'Биржи блогов');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие биржи ссылок используете?', 5, 'MultipleQuestionType');
    $question->AddDepend($answer35_2);

    $this->addAnswer($question, 'Sape (sape.ru)');
    $this->addAnswer($question, 'MainLink (mainlink.ru)');
    $this->addAnswer($question, 'LinkFeed (linkfeed.ru)');
    $this->addAnswer($question, 'SetLinks (setlinks.ru)');
    $this->addAnswer($question, 'TrustLink (trustlink.ru)');
    $this->addAnswer($question, 'Gogetlinks (gogetlinks.net)');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие биржи статей используете?', 5, 'MultipleQuestionType');
    $question->AddDepend($answer35_3);

    $this->addAnswer($question, 'Liex (liex.ru)');
    $this->addAnswer($question, 'SeoZavr (sepzavr.ru)');
    $this->addAnswer($question, 'MiraLinks (miralinks.ru)');
    $this->addAnswer($question, 'Другое: ', 1);


    $question = $this->addQuestion('Какие биржи блогов используете?', 5, 'MultipleQuestionType');
    $question->AddDepend($answer35_4);

    $this->addAnswer($question, 'Blogun (blogun.ru)');
    $this->addAnswer($question, 'RotaPost (rotapost.ru)');
    $this->addAnswer($question, 'Другое: ', 1);




    $question = $this->addQuestion('Оцените биржи ссылок', 5, 'CriterionQuestionType');
    $question->AddDepend($answer35_2);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Качество рекламы', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Sape (sape.ru)');
    $this->addAnswer($question, 'MainLink (mainlink.ru)');
    $this->addAnswer($question, 'LinkFeed (linkfeed.ru)');
    $this->addAnswer($question, 'SetLinks (setlinks.ru)');
    $this->addAnswer($question, 'TrustLink (trustlink.ru)');
    $this->addAnswer($question, 'Gogetlinks (gogetlinks.net)');


    $question = $this->addQuestion('Оцените биржы статей', 5, 'CriterionQuestionType');
    $question->AddDepend($answer35_3);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Количество программ/ офферов', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Liex (liex.ru)');
    $this->addAnswer($question, 'SeoZavr (sepzavr.ru)');
    $this->addAnswer($question, 'MiraLinks (miralinks.ru)');


    $question = $this->addQuestion('Оцените биржи блогов', 5, 'CriterionQuestionType');
    $question->AddDepend($answer35_4);
    $question->QuestionType()->SetParams(array(
      'MinRate' => 1,
      'MaxRate' => 5,
      'Criterions' => array('Доходность', 'Количество программ/ офферов', 'Удобство работы')
    ));

    $this->addAnswer($question, 'Blogun (blogun.ru)');
    $this->addAnswer($question, 'RotaPost (rotapost.ru)');


    /*****************  STEP 6 ***********************/


    $question = $this->addQuestion('Отранжируйте критерии по важности при оценки доходности метода монетизации', 6, 'RankQuestionType');
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'Потенциальная совокупная доходность');
    $this->addAnswer($question, 'eCPM (Эффективная/реальная стоимость тысячи показов)');
    $this->addAnswer($question, 'Тематичность');
    $this->addAnswer($question, 'Качество рекламных-материалов');
    $this->addAnswer($question, 'Качество товара/услуги');
    $this->addAnswer($question, 'Имидж рекламодателя');
    $this->addAnswer($question, 'Полезность для аудитории веб-проекта');


    $question = $this->addQuestion('Опишите Вашу структуру дохода', 6, 'InputListQuestionType');
    $question->AddDepend($answer1_2);
    $question->QuestionType()->SetParams(array(
      'Criterions' => array('Объем дохода за 2011 год (в %)', 'Объем дохода за 2010 год (в %)')
    ));

    $this->addAnswer($question, 'Продажа рекламы с оплатой за показы');
    $this->addAnswer($question, 'Продажа рекламы с оплатой за клики/переходы');
    $this->addAnswer($question, 'Продажа рекламы с оплатой за действия');
    $this->addAnswer($question, 'Продажа SEO ссылок/статей');
    $this->addAnswer($question, 'Продажа онлайн-услуг (сервисная модель)');
    $this->addAnswer($question, 'Продажа товаров/услуг (коммерческая модель)');


    $question = $this->addQuestion('Хотите участвовать в розыгрыше поощрительных призов? ', 6, 'InfoQuestionType', 'Для участия в розыгрыше призов Вам необходимо заполнить три нижеследующих поля.', 0);
    $question->AddDepend($answer1_2);


    $question = $this->addQuestion('Ваше имя', 6, 'InputQuestionType', '', 0);
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'Ваше имя');


    $question = $this->addQuestion('Ваш e-mail', 6, 'InputQuestionType', '', 0);
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'Ваш e-mail');

    $question = $this->addQuestion('Моб. телефон', 6, 'InputQuestionType', 'Указывайте телефон в формате +7 (495) 123-4567', 0);
    $question->AddDepend($answer1_2);

    $this->addAnswer($question, 'Моб. телефон');


  }


  /**
   * @param $questionText
   * @param $stepId
   * @param $type
   * @param string $description
   * @param int $required
   * @param $validator
   * @return VoteQuestion
   */
  private function addQuestion($questionText, $stepId, $type, $description = '', $required = 1, $validator = null)
  {
    $question = new VoteQuestion();
    $question->VoteId = 1;
    $question->Question = $questionText;
    $question->Description = $description;
    $question->StepId = $stepId;
    $question->Type = $type;
    $question->Validator = $validator;
    $question->Required = $required;
    $question->save();

    return $question;
  }

  /**
   * @param $question
   * @param $answerText
   * @param int $custom
   * @return VoteAnswer
   */
  private function addAnswer($question, $answerText, $custom = 0)
  {
    $answer = new VoteAnswer();
    $answer->QuestionId = $question->QuestionId;
    $answer->Answer = $answerText;
    $answer->Custom = $custom;
    $answer->save();

    return $answer;
  }


  protected function showResult($resultId)
  {
    /** @var $results VoteResultAnswer[] */
    $results = VoteResultAnswer::model()->with('Answer')->findAll('t.ResultId = :ResultId', array(':ResultId' => $resultId));

    foreach ($results as $result)
    {
      echo $result->Answer->Answer . ': ' . ($result->Custom != null ? base64_decode($result->Custom) : '') . '<br>';
    }
  }
}