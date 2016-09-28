<?php
/**
 * @var \user\models\User $user
 */
$productAccess = new \pay\models\ProductUserAccess();
$productAccess->ProductId = 3114;
$productAccess->UserId = $user->Id;
$productAccess->save();
?>
<h3><?=$user->getFullName()?>, здравствуйте!</h3>
<p>С 6 по 8 февраля конференц-центр Digital October распахнет свои двери для сообщества, формирующего мир свободно распространяемых СУБД. Simon Riggs, Илья Космодемьянский, Marco Slot, Александр Киров, Julien Rouhaud, Дмитрий Барышников и еще более 40 спикеров форума <a href="http://pgconf.ru/">PGCONF.RUSSIA 2015</a>&nbsp;представят вам будущее PostgreSQL.</p>
<p>В рамках <a href="http://pgconf.ru/papers">сформированной программы форума</a> будут обсуждаться альтернативы коммерческим продуктам в системах, важных для государства и бизнеса, возможность использования в критически важных приложениях, эксплуатация высоконагруженных систем, инструменты для администрирования и разработки масштабируемых приложений.</p>

<hr style="border:0;border-top: 1px solid #eaeaea; height: 1px; margin: 25px 0;" />

<h3>Анонсы докладов <a href="http://pgconf.ru/papers">программы форума</a>:</h3>

<table style="width:100%; margin: 0 auto">
	<tbody>
		<tr>
			<td style="width: 60%; vertical-align:top">
			<p style="font-weight: bold"><a href="http://pgconf.ru/paper/1">Основатель компании 2nd Quadrant : Двунаправленная репликация (BDR) - новый прорыв в возможностях PostgreSQL</a></p>

			<p>Архитектура и особенности двунаправленной репликации</p>
			</td>
			<td width="15">&nbsp;</td>
			<td style="width: 15%; vertical-align:middle; text-align: center"><img alt="" src="http://pgconf.ru/static/images/persons/simon_riggs.jpg" style="-webkit-border-radius: 75px; -moz-border-radius: 75px; border-radius: 75px; margin: 0 auto" width="90" /></td>
			<td style="width: 25%; vertical-align:middle">
			<p style="font-weight: bold">Simon Riggs</p>

			<p>Ведущий разработчик PostgreSQL</p>
			</td>
		</tr>
		<tr>
			<td style="width: 60%; vertical-align:top">
			<p style="font-weight: bold"><a href="http://pgconf.ru/paper/18">Масштабирование PostgreSQL для обеспечения работы систем с потоками высокой интенсивности и высокой нагрузки.</a></p>

			<p>Мы представляем новое расширение, позволяющее реализовать масштабирование PostgreSQL для высоконагруженных систем.</p>
			</td>
			<td width="15">&nbsp;</td>
			<td style="width: 15%; vertical-align:middle; text-align: center"><img alt="" src="http://pgconf.ru/static/images/persons/slot.jpg" style="-webkit-border-radius: 75px; -moz-border-radius: 75px; border-radius: 75px; margin: 0 auto" width="90" /></td>
			<td style="width: 25%; vertical-align:middle">
			<p style="font-weight: bold">Марко Слот<br/>(Marco Slot)</p>

			<p>Citus Data</p>
			</td>
		</tr>
		<tr>
			<td style="width: 60%; vertical-align:top">
			<p style="font-weight: bold"><a href="http://pgconf.ru/paper/24">Производительность PostgreSQL в Linux-контейнерах и поверх Parallels Cloud Storage</a></p>

			<p>Мы покажем как PostgreSQL работает внутри контейнеров Parallels и сравним его производительность с PostgreSQL, работающем без виртуализации.</p>
			</td>
			<td width="15">&nbsp;</td>
			<td style="width: 15%; vertical-align:middle; text-align: center"><img alt="" src="http://pgconf.ru/static/images/persons/kirov.jpg" style="-webkit-border-radius: 75px; -moz-border-radius: 75px; border-radius: 75px; margin: 0 auto" width="90" /></td>
			<td style="width: 25%; vertical-align:middle">
			<p style="font-weight: bold">Александр Киров</p>

			<p>Parallels</p>
			</td>
		</tr>
		<tr>
			<td style="width: 60%; vertical-align:top">
			<p style="font-weight: bold"><a href="http://pgconf.ru/paper/23">Успешная история перевода большой ИТ системы с Oracle на PostgreSQL в рамках стратегии импортозамещения</a></p>

			<p>Возможна ли миграция с коммерческой системы на PostgreSQL? Будет представлен опыт миграции ERP системы с СУБД Oracle на СУБД PostgreSQL для предприятия атомной отрасли. Рассмотрены предпосылки проекта &ndash; ужесточение одобрения экспортных лицензий на американские ИТ продукты, логика и опыт анализа и выбора возможных вариантов миграции, вопросы сертификации решения и аттестации системы.</p>
			</td>
			<td width="15">&nbsp;</td>
			<td style="width: 15%; vertical-align:middle; text-align: center"><img alt="" src="http://pgconf.ru/static/images/persons/izraylev.jpg" style="-webkit-border-radius: 75px; -moz-border-radius: 75px; border-radius: 75px; margin: 0 auto" width="90" /></td>
			<td style="width: 25%; vertical-align:middle">
			<p style="font-weight: bold">Иван Израйлев</p>

			<p>Ланит-Урал</p>
			</td>
		</tr>
		<tr>
			<td style="width: 60%; vertical-align:top">
			<p style="font-weight: bold"><a href="http://pgconf.ru/paper/14">Мониторинг кластеров PostgreSQL с помощью OPM и PoWA</a></p>

			<p>Мониторинг PostgreSQL является важной частью управления. OPM (Open PostgreSQL monitoring) - новое решение для обработки и визуализации событий в PostgreSQL.</p>
			</td>
			<td width="15">&nbsp;</td>
			<td style="width: 15%; vertical-align:middle; text-align: center"><img alt="" src="http://pgconf.ru/static/images/persons/rouhaud.jpg" style="-webkit-border-radius: 75px; -moz-border-radius: 75px; border-radius: 75px; margin: 0 auto" width="90" /></td>
			<td style="width: 25%; vertical-align:middle">
			<p style="font-weight: bold">Жульен Рохауд<br/>(Julien Rouhaud)</p>

			<p>Dalibo, Франция</p>
			</td>
		</tr>
	</tbody>
</table>

<p>Организационный комитет форума приглашает вас, предоставляя специальные условия участия, которые доступны по промо-коду <b>runetid</b>! Промокод - <b>runetid</b>, дает скидку 15 % на участие при регистрации до 1 февраля 2015 года</p>

<hr style="border:0;border-top: 1px solid #eaeaea; height: 1px; margin: 25px 0;" />

<p><b>Специально для вас мы подготовили пакет "Участие + проживание" по специальной цене 12000 рублей. Он станет доступен при переходе по ссылке регистрации ниже.</b></p>

<p style="margin-top: 20px 0; text-align: center;">
    <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/pgcr15/')?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Зарегистрироваться</a>
</p>
