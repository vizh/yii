<h2><?=$user->getShortName()?>, здравствуйте!</h2>

<p>Напоминаем, что Вы зарегистрировались на Международный Форум по Кибербезопасности / <strong>Cyber Security Forum 2014, Russia</strong> &ndash; <a href="http://cybersecurityforum.ru">www.CyberSecurityForum.ru</a></p>

<p>Мероприятие пройдет <strong>19 февраля (среда) 2014 года</strong> в Москве в Торгово-Промышленной Палате РФ (ул. Ильинка д.6). Регистрация участников на месте с 9:00 до 17:00.</p>

<p><a href="http://runet-id.com/event/csf14/#event_widgets_tabs_Html" style="display: block; text-decoration: none; background: #3c3f41; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; margin: 0 auto; padding: 12px; text-align: center; width: 150px;">Программа Форума</a></p>

<h3>ВНИМАНИЕ!</h3>
<p>Ваш статус &mdash; <b>виртуальный участник</b>.</p>

<p>Он позволяет Вам следить за новостями Форума, но <b>не дает возможности посетить мероприятие</b>.</p>
<p>Для посещения мероприятия требуется завершить регистрацию: внести регистрационный взнос (1500 руб. включая все налоги) или получить аккредитарцию Оргкомитета (доступна для докладчиков, представителей СМИ, партнеров НП &ldquo;РАЭК&rdquo;).

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(870);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/csf14/');
?>

<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #FF7370; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">Завершить регистрацию &raquo;</a></p>