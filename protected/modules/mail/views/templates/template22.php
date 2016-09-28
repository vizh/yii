<style>
  ul li {margin: 3px 0 !important;}
</style>

<h2><?=$user->getShortName()?>, здравствуйте!</h2>

<p>Продолжается регистрация участников и формирование программы Международного Форума по Кибербезопасности / <strong>Cyber Security Forum 2014, Russia</strong> &ndash; <a href="http://cybersecurityforum.ru">www.CyberSecurityForum.ru</a></p>
Форум пройдет <strong>19 февраля 2014 года</strong> в Москве в Торгово-Промышленной Палате РФ.

<p>К участию приглашаются специалисты в области информационной безопасности, российские и зарубежные эксперты, интернет-игроки, интернет-провайдеры, производители программно-аппаратных решений, представители профильных органов государственной власти, представители СМИ &ndash; всего в Форуме примут участие более 500 экспертов.</p>
<strong>Программа Форума 19 февраля 2014 состоит из следующих блоков:</strong>

<ul>
	<li>Регистрация участников (с 9:00 до 17:00);</li>
	<li>Открытие / Пленарное заседание (с участием представителей интернет-компаний и профильных органов госвласти);</li>
	<li>
    Секционные заседания по темам:
    <ul>
      <li>Технологии информационной безопасности: как сохранить целостность интернета;</li>
      <li>Законодательство в сфере кибербезопасности: российские и международные практики;</li>
     	<li>Перспективы развития контента и сервисов для целевых групп: в приоритете ДЕТИ;</li>
     	<li>Безопасность в сфере электронной коммерции: принципы и практики;</li>
     	<li>Вопросы инфобезопасности в сфере мобильной коммуникации;</li>
     	<li>Нелегальный контент. Принципы предотвращения угроз;</li>
     	<li>Защита контента в сети. Проблемы и решения;</li>
     	<li>Информационная безопасность и вопросы детской безопасности;</li>
    </ul>
  </li>
	<li>Итоговый круглый стол (Стратегия кибербезопасности: локальный или международный подход?)</li>
</ul>
В ходе будет работать выставка, посвященная вопросам информационной безопасности. &nbsp;

<p>Cyber Security Forum &ndash; это площадка для диалога отрасли и государства, российских и зарубежных экспертов, это площадка для обмена опытом и поиска в решений в области информационной безопасности и борьбы с киберугрозами современности.</p>

<table style="width: 100%">
  <tr>
    <td><a href="http://CyberSecurityForum.ru" style="display: block; text-decoration: none; background: #3c3f41; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; margin: 0 auto; padding: 12px; text-align: center; width: 150px;">О Форуме</a></td>

    <td><a href="http://runet-id.com/event/csf14/users/" style="display: block; text-decoration: none; background: #3c3f41; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; margin: 0 auto; padding: 12px; text-align: center; width: 150px;">Участники</a></td>

    <td><a href="http://runet-id.com/event/csf14/#event_widgets_tabs_Html" style="display: block; text-decoration: none; background: #3c3f41; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; margin: 0 auto; padding: 12px; text-align: center; width: 150px;">Программа</a></td>
  </tr>
</table>

<h3>ВНИМАНИЕ!</h3>

<p>Принять участие в Cyber Security Forum 19 февраля 2014 года &ndash; могут <strong>только зарегистрированные участники</strong>.</p>

<p>Проверить статус участия и произвести регистрацию / дорегистрацию / оплату регистрационного взноса:</p>

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(870);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/csf14/');
?>

<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #FF7370; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">Быстрая регистрация &raquo;</a></p>

<p>До встречи на Форуме!</p>