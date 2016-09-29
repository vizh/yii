<h2><?=$user->getShortName()?>, здравствуйте!</h2>

<p>RUNET-ID предлагает быструю регистрацию на главные весенние мероприятия Рунета:</p>

<p><img src="http://runet-id.com/images/mail/dg14/header-bg-1.png"></p>

<p><strong>4 МАРТА, DIGITAL OCTOBER<br />
<span style="font-size: 24px;">Digital Goods 2014 &ndash; конференция про электронную торговлю и цифровые товары</span></strong></p>

<p>Уже через неделю пройдет конференция <a href="http://www.dgconf.com">Digital Goods 2014</a>, посвященная развитию электронной коммерции и потреблению цифровых товаров в Интернете.</p>

<p>Компании-участники: OZON.ru, PayPal, ВТБ-24, Ru-Center, Sanoma Independent Media, PayOnline, MOBI.Деньги, LinguaLeo, LITRES.ru, RusBase, Наносемантика и другие.</p>

<p>Программа Digital Goods 2014 представлена тремя потоками:</p>

<ul>
	<li><a href="http://www.dgconf.com/program/#business">Business</a></li>
	<li><a href="http://www.dgconf.com/program/#technology">Technology</a></li>
	<li><a href="http://www.dgconf.com/program/#marketing">Marketing</a></li>
</ul>

<p>Успейте зарегистрироваться до конца текущей недели (стоимость участия: 5000 руб.)</p>

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(866);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/dg14/');
?>

<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #D85939; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 250px;">Регистрация</a></p>

<hr style="margin: 25px 0; height: 1px; border: 0; border-bottom: 1px solid #dfdfdf;" />

<p><img src="http://runet-id.com/images/mail/20therunet/header-bg.png"></p>

<p><strong>7 АПРЕЛЯ, ARENA MOSCOW<br />
<span style="font-size: 24px;">День рождения &laquo;РУНЕТУ &ndash; 20 лет!&raquo;</span></strong></p>

<p>Праздничное шоу и концерт <a href="http://runet-id.com/event/20therunet/">&laquo;Рунету &ndash; 20 лет!&raquo;</a> &mdash; прекрасный повод отметить праздник в кругу друзей и хороших знакомых в торжественной обстановке под музыку любимых исполнителей.</p>

<p>Стоимость билета &ndash; 2000 руб (при оплате до 15 марта 2014 года).</p>

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(877);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/20therunet/');
?>
<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #D85939; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 250px;">Купить билет</a></p>

<hr style="margin: 25px 0; height: 1px; border: 0; border-bottom: 1px solid #dfdfdf;" />

<p><img src="http://runet-id.com/images/mail/rif14/header-bg.png"></p>

<p><strong>23-25 АПРЕЛЯ, ПАНСИОНАТЫ &laquo;ПОЛЯНЫ&raquo; и &laquo;ЛЕСНЫЕ ДАЛИ&raquo;<br />
<span style="font-size: 24px;">РИФ+КИБ 2014: Весна. Интернет. Конференция</span></strong></p>

<p>18-й <a href="http://www.rif.ru">Российский Интернет Форум</a> (РИФ+КИБ 2014) &ndash; главное весеннее мероприятие Рунета.</p>

<p>Форум традиционно проходит в формате выездного подмосковного трехдневного мероприятия, состоящего из Конференции, Выставки и Внепрограммных мероприятий.</p>

<p><a href="http://2014.russianinternetforum.ru/program/">В конференционной программе</a> представлены все темы развития Рунета (около 100 секций, круглых столов и мастер-классов, всего более 500 докладчиков).</p>

<p>В программе РИФ+КИБ помимо основных выступлений &ndash; уникальные ток-шоу с интернет-гуру, презентации новинок лидерами отрасли, конференция для инвесторов и стартапов UpStart Conf, конференция Crowd Conf, специальные треки &ldquo;Brand Track&rdquo; и &ldquo;HR Track&rdquo;, секции народной Программы 2.0, кулуарное общение и многое другое. &nbsp;</p>

<p>Все дни проведения РИФ+КИБ работать выставка лидеров Рунета, а все дни и вечера &ndash; будут проходить специальные мероприятия от партнеров Форума, открытые и закрытые встречи, вечеринки и развлекательные акции.</p>

<p>РИФ+КИБ &ndash;&nbsp;это самое главное, самое полезное, самое позитивное и самое весеннее событие Рунета.</p>

<p>Стоимость регистрационного платежа &ndash; 6000 рублей, включая налоги &ndash; при оплате до 1 марта.</p>

<h3>Спешите зарегистрироваться и оплатить участие&nbsp;до 1 марта!</h3>

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(789);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/rif14/');
?>
<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #D85939; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 250px;">Регистрация</a></p>

<hr style="margin: 25px 0; height: 1px; border: 0; border-bottom: 1px solid #dfdfdf;" />

<p><img src="http://runet-id.com/images/mail/spic2014/header-bg.jpg"></p>

<p><strong>27 И 28 МАЯ, Г.САНКТ-ПЕТЕРБУРГ, ПРИБАЛТИЙСКАЯ PARK INN<br />
<span style="font-size: 24px;">Санкт Петербургская Интернет Конференция 2014</span></strong></p>

<p>9-я Санкт-Петербургская интернет-конференция (<a href="http://www.sp-ic.ru">СПИК 2014</a>) традиционно привлечет профессиональную аудиторию Северо-Запада России, а также представителей различных отраслей бизнеса, которым интересен интернет-аспект развития их компаний, в том числе представителей офлайнового бизнеса, госсектора, заказчиков и рекламодателей.</p>

<p>В этом году <a href="http://2014.sp-ic.ru/program/">программа СПИК 2014</a> будет включать в себя все главные темы развития интернета, а акцент будет сделан на темах: интернет-маркетинг и реклама, веб-аналитика, SEO, веб-разработка и разработка мобильных приложений, электронная коммерция и т.д. Отдельным блоком пройдут мастер-классы по специализированным тематикам, где специалисты поделятся опытом создания, развития и продвижения бизнеса в интернете.</p>

<p>Параллельно с конференционной программой в рамках СПИК пройдет выставка интернет-компаний, на которой свои продукты и решения представят ведущие отраслевые игроки. Посещение выставки &ndash; бесплатное для всех зарегистрированных участников СПИК 2014.</p>

<p>До конца февраля &ndash; действует специальное предложение для участников конференционной программы: посещение всех пяти залов СПИК 2014 обойдется в 2 000 рублей, включая налоги.</p>

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(663);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/spic2014/');
?>
<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #D85939; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 250px;">Регистрация</a></p>

<hr style="margin: 25px 0; height: 1px; border: 0; border-bottom: 1px solid #dfdfdf;" />
<p>До встречи на профессиональных весенних конференциях Рунета &ndash; http://2014.runet-id.com</p>
