<?php
/**
 * @var User $user
 */
use user\models\User;
$secret = 'vuNxjCDOuwEYt1WK';
$hash = substr(md5($secret.'rifvrn'.$user->RunetId), 1, 16);
$regLink = sprintf('http://2014.rifvrn.ru/register-mail?rid=%s&h=%s', $user->RunetId, $hash);
?>

<p><img src="http://showtime.s3.amazonaws.com/20140929-rifvrn_640.png" style="border: 0; height: auto; width: 100%;" /></p>

<h3><?=$user->getShortName()?>, здравствуйте!</h3>
<p><a href="http://2014.rifvrn.ru"><nobr>РИФ-Воронеж</nobr></a> 2014&nbsp;&mdash; главное <nobr>интернет-мероприятие</nobr> Черноземья&nbsp;&mdash; пройдет <nobr>3&mdash;4 октября</nobr> 2014 года в&nbsp;<nobr>конгресс-отеле</nobr> &laquo;Бенефит Плаза&raquo;.</p>
<p><b><nobr>РИФ-Воронеж</nobr> 2014&nbsp;&mdash; это:</b></p>
<ul><li>профессиональная программа, состоящая из&nbsp;четырех тематических потоков: Маркетинг и&nbsp;реклама, Технический поток, Государство и&nbsp;общество, Стартапы и&nbsp;инвестиции</li></ul>
<ul><li>более 70 спикеров из&nbsp;ведущих <nobr>интернет-компаний</nobr> России, специалистов в&nbsp;области <nobr>веб-разработок</nobr>, дизайна, <nobr>интернет-маркетинга</nobr>, поисковой оптимизации <nobr>и т. д.</nobr></li></ul>
<ul><li>специальный гость в&nbsp;потоке &laquo;Стартапы и&nbsp;инвестиции&raquo; Гари А.Фаулер -признанный гуру в&nbsp;области маркетинга, предприниматель, <nobr>бизнес-коуч</nobr>, ментор. </li></ul>
<ul><li>внепрограммные мероприятия: презентация и&nbsp;промо от&nbsp;отраслевых компаний, <nobr>кофе-брейки</nobr> от&nbsp;организаторов, <nobr>интернет-вечеринка</nobr>, церемония награждения победителей премии, конкурсы и&nbsp;подарки. </li></ul>
<ul><li>общение с&nbsp;коллегами по&nbsp;рынку, позитивные эмоции, невероятная атмосфера праздника&nbsp;&mdash; все это <nobr>РИФ-Воронеж</nobr> 2014!</li></ul>
<p>Осталось всего 3 дня!!! Спешите, регистрируйтесь!</p>
<p><a href="<?=$regLink?>" style="display: block; text-decoration: none; background: #5b9bd5; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">РЕГИСТРАЦИЯ</a></p>