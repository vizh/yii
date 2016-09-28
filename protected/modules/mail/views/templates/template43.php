<h2>Здравствуйте, <?=$user->getShortName()?>!</h2>

<p>Напоминаем, что у&nbsp;каждого <nobr>интернет-специалиста</nobr> есть возможность внести вклад в&nbsp;формирование Программы главного весеннего мероприятия Рунета&nbsp;&mdash; <nobr>18-го</nobr> Российского Интернет Форума &laquo;<a href="http://rif.ru">РИФ+КИБ 2014</a>&raquo;.</p>

<p>Сделать это можно через механизм &laquo;народной программы&raquo; (или Программы 2.0). Каждый участник Форума вправе предложить свой доклад в&nbsp;имеющиеся секции, или даже организовать и&nbsp;модерировать свою собственную секцию.</p>

<p>23&nbsp;марта (ровно за&nbsp;месяц до&nbsp;старта Форума)&nbsp;&mdash; заканчивается прием заявок на&nbsp;формирование Программы 2.0. Заявки принимает Оргкомитет, голосуют все участники РИФ+КИБ.</p>

<p>Оставить заявку на&nbsp;организацию своей секции в&nbsp;рамках Программы 2.0&nbsp;может каждый зарегистрированный участник:</p>

<p><a href="http://2014.russianinternetforum.ru/p2/add/ " style="display: block; text-decoration: none; background: #D85939; color: #FFFFFF; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">ПРЕДЛОЖИТЬ СЕКЦИЮ</a></p>

<p>По всем вопросам формирования Программы 2.0 можно обращаться по адресу - <a href="mailto:prog2@rif.ru">prog2@rif.ru</a></p>

<p>Зарегистрироваться на Форум и зарегистрировать коллег, заказать питание и забронировать проживание&nbsp;можно в личном кабинете участника:</p>

<?php
$regLink = "http://2014.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<p><a href="<?=$regLink?>" style="display: block; text-decoration: none; background: #D85939; color: #FFFFFF; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">ЛИЧНЫЙ КАБИНЕТ</a></p>

<h5 align="right"><em>С уважением,&nbsp;<br />
Оргкомитет 18-го Российского Интернет Форума<br />
РИФ+КИБ 2014&nbsp;</em></h5>
