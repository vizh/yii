<?php
	$event = \event\models\Event::model()->findByPk(1503);
	?>
<p><img src="http://showtime.s3.amazonaws.com/201502030856-pgc15-logo.png" style="height: auto; width: 100%;"/></p>
<h3>Здравствуйте <?=$user->getShortName();?>!</h3>
<p><nobr>6-7</nobr> февраля 2015 года в&nbsp;Москве <a href="http://pgconf.ru/">состоится</a> конференция разработчиков, пользователей и&nbsp;администраторов свободной <a href="http://www.postgresql.org/">СУБД PostgreSQL</a>. Кроме <a href="http://pgconf.ru/papers">докладов</a>, посвящённых устройству и&nbsp;особенностям использования PostgreSQL, на&nbsp;конференции также планируется обсудить с&nbsp;представителями бизнеса, государственных органов и&nbsp;компаний, использование PostgreSQL&nbsp;в качестве альтернативы коммерческим продуктам и&nbsp;продемонстрировать возможность использования данной СУБД в&nbsp;критически важных приложениях.</p>
<p>В&nbsp;Конференции примут участие ведущие разработчики и&nbsp;авторы многих значимых подсистем PostgreSQL, как отечественные, так и&nbsp;зарубежные, а&nbsp;также представители компаний, успешно использующих PostgreSQL&nbsp;в своём бизнесе. Компании раскажут об&nbsp;опыте и&nbsp;проблемах внедрения и&nbsp;эксплутации PostgreSQL, разработчики поделятся известными им&nbsp;тонкостями, расскажут о&nbsp;новых возможностях и&nbsp;перспективах развития PostgreSQL. Участие в&nbsp;конференции <a href="http://pgconf.ru/#participation">платное</a> (для иногородних в&nbsp;стоимость входит проживание), требуется предварительная <a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(24));?>">регистрация</a>.</p>
<h3>Основные темы конференции:</h3>
<ul> 
	<li><p><strong>PostgreSQL как промышленная СУБД.</strong> Репликация и&nbsp;бэкап&nbsp;— различные подходы и&nbsp;продукты, двунаправленная репликация (BDR), параллельная обработка, кластеры, Postgres&nbsp;XL, масштабируемость, отказоустойчивость. Высокие нагрузки. Крупнейшие пользователи PostgreSQL&nbsp;в России и&nbsp;их&nbsp;опыт&nbsp;— Avito, Yandex и&nbsp;др. Администрирование больших систем. Мониторинг, настройки, оптимизация. Миграция на&nbsp;PostgreSQL и&nbsp;его интеграция с&nbsp;другим ПО. Взаимодействие PostgreSQL&nbsp;с операционной системой и&nbsp;аппаратными средствами, оптимальные настройки.</p></li>
	<li><p><strong>Подробности от&nbsp;разработчиков.</strong> Слабо-структурированные данные: Hstore, JSON, JSONB, XML. PostgreSQL&nbsp;vs MongoDB. Расширяемость PostgreSQL: пользовательские типы данных и&nbsp;индексы. Новые механизмы репликации. Внутренности PostgreSQL. Data Change Streaming API. Оптимизация запросов.</p></li>
	<li><p><strong>PostgreSQL&nbsp;в России: актуальные проблемы.</strong> Тема импортозамещения и&nbsp;технологической независимости от&nbsp;иностранных поставщиков заставили многих, ранее пренебрежительно отворачивавшихся от&nbsp;свободного&nbsp;ПО, задуматься о&nbsp;нем всерьез. Неожиданно оказалось, что PostgreSQL является практически единственной СУБД, которая способна решить многие проблемы, а&nbsp;в&nbsp;России уже сформировалось заметное сообщество её&nbsp;разработчиков, пользователей и&nbsp;энтузиастов. Многие доклады будут посвящены опыту внедрения PostgreSQL&nbsp;в государственных проектах и&nbsp;вопросам миграции на&nbsp;PostgreSQL и&nbsp;сравнению его с&nbsp;другими СУБД.</p></li>
 </ul>
<h3>Некоторые доклады:</h3>
<ul> 
	<li><p>Ожидается доклад создателя европейской компании 2ndQuadrant и&nbsp;одной из&nbsp;ключевых фигур в&nbsp;международном сообществе PostgreSQL Саймона Риггса о&nbsp;<strong>killer-feature постгреса&nbsp;— двунаправленной репликации (BDR)</strong>. Это новая возможность PostgreSQL, позволяющая организовывать асинхронную multi-master репликацию в&nbsp;географически распределенных базах данных.</p></li>
	<li><p>Mason Sharp из&nbsp;комании TransLattice расскажет о&nbsp;масштабируемой, свободно распространяемой <strong>кластерной системе Postgres-XL, предназначенной для создания OLAP и&nbsp;OLTP-систем</strong>, позволяющей организовывать параллельную обработку запросов с&nbsp;сохранением транзакционной целостности в&nbsp;масштабе всего кластера.</p></li>
	<li><p>Олег Бартунов из&nbsp;МГУ и&nbsp;Александр Коротков из&nbsp;«Интаро-Софт» расскажут <strong>о&nbsp;новых возможностях по&nbsp;эфективной и&nbsp;быстрой работе PostgreSQL&nbsp;со слабоструктурированными данными, о&nbsp;XML, JSON и&nbsp;VODKA</strong>. Также они расскажут про системы расширяемости PostgreSQL, как эффективно работать с&nbsp;пространственными данными (GIS), как устроены индексы и&nbsp;почему PostgreSQL&nbsp;— самая расширяемая СУБД.</p></li>
	<li><p>Dimitri Fontaine из&nbsp;Франции&nbsp;— опытнейший разработчик модулей и&nbsp;расширений PostgreSQL, широко известный популяризатор PostgreSQL и&nbsp;практик, имеющий огромный опыт эксплуатации больших баз данных, поделится своим видением <strong>соотношения SQL- и&nbsp;noSQL-подходов в&nbsp;современных базах данных</strong>.</p></li>
	<li><p>Tatsuo Ishii&nbsp;— президент Японского отделения международной компании SRA OSS, автор PgBench и&nbsp;PgPool расскажет,<strong> почему в&nbsp;Японии PostgreSQL очень популярен</strong> и&nbsp;поддерживается команиями NTT и&nbsp;Fujitsu.</p></li>
	<li><p>Михаил Тюрин&nbsp;— главный системный архитектор в&nbsp;Авито (крупнейший в&nbsp;России сервис частных объявлений) расскажет об&nbsp;опыте <strong>безостановочной эксплутатации крупных баз данных под большой нагрузкой</strong>, о&nbsp;взаимодействии PostgreSQL&nbsp;с операционной системой, поделится некоторыми деталями архитектуры Avito.</p></li>
	<li><p>Илья Космодемьянский (PostgreSQL-Consulting.com) расскажет <strong>о&nbsp;разнице подходов к&nbsp;эксплуатации коммерческих СУБД</strong> Oracle, DB2, MS&nbsp;SQL Server и&nbsp;СУБД с&nbsp;открытым исходным кодом PostgreSQL, о&nbsp;методиках переподготовки специалистов и&nbsp;историях успешной миграции на&nbsp;PostgreSQL&nbsp;с проприетарных решений.</p></li>
	<li><p>Федор Сигаев из&nbsp;Mail.RU, член международной команды разработчиков ядра PostgreSQL, создатель intarray и&nbsp;hstore, расскажет о&nbsp;своей работе над <strong>поддержкой слабоструктурированных типов данных, о&nbsp;механизмах расширяемости PostgreSQL</strong> и&nbsp;перспективах их&nbsp;развития.</p></li>
	<li><p>Жан-Поль Аргудо, основатель французской компании Dalibo, расскажет об&nbsp;опыте заимодействия с&nbsp;государственными структурами Франции и&nbsp;становлении рынка услуг на&nbsp;базе PostgreSQL. Сотрудники Dalibo Жульен Рухо и&nbsp;Жиль Дароль поделятся <strong>опытом миграции с&nbsp;Oracle и&nbsp;расскажут о&nbsp;созданной ими системе мониторинга OPM/PoWA</strong>.</p></li>
	<li><p>Дениш Патель, ведущий архитектор компании OmniTI, продемонстрирует пригодность <strong>PostgreSQL для создания систем процесинга банковских карт</strong>, соответствующих международным PCI, используемым VISA и&nbsp;MasterCard.</p></li>
	<li><p>Игорь Жуков и&nbsp;Сергей Муравьев из&nbsp;ОАО «Концерн радиоэлектронных технологий» расскажут о&nbsp;выборе <strong>СУБД для импортозамещения в&nbsp;чувствительных государственных проектах</strong>.</p></li>
	<li><p>Сергей Мелехин из&nbsp;компании Emply (г. Владивосток), на&nbsp;своем личном опыте прошедший миграцию из&nbsp;Oracle, расскажет <strong>о&nbsp;тестировании хранимых функций в&nbsp;PostgreSQL</strong> и&nbsp;сравнит экосистемы PostgreSQL и&nbsp;Oracle.</p></li>
	<li><p>Мишель Паке, автор известного блога о&nbsp;новых возможностях PostgreSQL, подведет итоги подготовки нового релиза 9.5, замораживание которого ожидается к&nbsp;конференции, и&nbsp;<strong>расскажет о&nbsp;возможностях новой версии</strong>&nbsp;— прежде всего, это усовершенствования в&nbsp;механизмах репликации и&nbsp;блокировок, row-level security.</p></li>
	<li><p>Андрей Борисов из&nbsp;ООО «РусБИТех» расскажет о&nbsp;применимости <strong>PostgreSQL&nbsp;в системах, связанных с&nbsp;государственной тайной</strong>.</p></li>
	<li><p>Иван Израйлев из&nbsp;«Ланит-Урал» поделится историей успеха при <strong>миграции на&nbsp;PostgreSQL информационной системы в&nbsp;атомной отрасли</strong>.</p></li>
	<li><p>Владимир Бородин из&nbsp;«Яндекса» продолжит свою серию докладов <strong>о&nbsp;внедрении PostgreSQL&nbsp;в почте Яндекса</strong> и&nbsp;его работе под высокой нагрузкой.</p></li>
	<li><p>Александр Чистяков из&nbsp;Git on&nbsp;Sky выступит с&nbsp;докладом <strong>«Как пасти слонов : эксплуатация PostgreSQL&nbsp;с графиками и&nbsp;всем остальным»</strong>, в&nbsp;котором поделится опытом работы по&nbsp;оптимизации производительности и&nbsp;облуживанию инфраструктуры заказчиков, практикой использования различных инструментов, таких как pgpool-II, POWA, Bucardo, и&nbsp;расскажет о&nbsp;используемых средах мониторинга на&nbsp;основе statsd и&nbsp;Graphite.</p></li>
	<li><p><strong>Об&nbsp;использовании PostgreSQL&nbsp;в геоинформационных системах</strong> расскажет разработчик PostGIS Vincent Picvet и&nbsp;представитель российской компании NextGIS Дмитрий Барышников.</p></li>
 </ul>
 <div style="text-align: center; border: 3px dashed #0D6C8E; margin-top: 20px;">
	<p><strong>ВНИМАНИЕ!</strong><br/>Принять участие в&nbsp;форуме могут только зарегистрированные участники.</p>
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(24));?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #0D6C8E; margin: 0 10px 0 0; padding: 0; border-color: #0D6C8E; border-style: solid; border-width: 10px 40px;">Быстрая регистрация</a></p>
	<p align="center">До&nbsp;встречи на&nbsp;Форуме!</p>
</div>