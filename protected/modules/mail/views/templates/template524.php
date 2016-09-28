<?php
$regLink = "http://2015.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);

$translite = new \ext\translator\Translite();
$reporter = $translite->translit($user->LastName);

$userCode = mb_convert_case('SPIC15_' . $reporter, MB_CASE_UPPER);
$discount = \pay\models\Coupon::model()->byCode($userCode)->byEventId(1580)->find();
if (empty($discount)) {
    $discount = new \pay\models\Coupon();
    $discount->EventId  = 1580;
    $discount->Code = $userCode;
    $discount->Multiple = true;
    $discount->MultipleCount = 50;
    $discount->EndTime  = null;
    $discount->Discount = (float) 30 / 100;
    $discount->save();
}
?>

<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>Вы&nbsp;&mdash; докладчик Санкт-Петербургской Интернет Конференции (СПИК 2015)&nbsp;&mdash;<a href="http://www.sp-ic.ru/"> www.sp-ic.ru.</a></p>

<p>Конференция пройдет <nobr>28-29</nobr> мая 2015 года в&nbsp;конференц-центре гостиницы &laquo;Прибалтийская Park Inn&raquo; (ул. Кораблестроителей, д.14).</p>

<h3>Оргкомитет рекомендует:</h3>

<ol>
	<li>Внимательно изучить&nbsp;<a href="http://2015.sp-ic.ru/program/">программу СПИКа</a> и&nbsp;найти&nbsp;в&nbsp;ней себя, проверить правильность и полноту представленной информации.</li>
	<li>Запланировать дату и&nbsp;время Вашего участия в&nbsp;СПИКе. Вам необходимо прибыть на&nbsp;площадку минимум за&nbsp;30&nbsp;минут до&nbsp;начала Вашей секции (регистрация на&nbsp;месте будет работать все 2&nbsp;дня с&nbsp;9:00 до&nbsp;18:00).</li>
	<li>Распечатать <a href="<?=$user->Participants[0]->getTicketUrl()?>">путевой лист</a>, наличие которого ускорит процедуру регистрации на площадке.</li>
</ol>

<h3>Ознакомьтесь с&nbsp;памятками:</h3>

<ul>
	<li><a href="http://2015.sp-ic.ru/about/speakers/">Подробная памятка докладчика</a></li>
	<li><a href="http://2015.sp-ic.ru/about/moderator/">Памятка модератора/ведущего</a></li>
</ul>

<p>В&nbsp;случае возникновения любых дополнительных вопросов по&nbsp;программе&nbsp;&mdash; обращайтесь в&nbsp;Программный комитет: <a href="mailto:prog@sp-ic.ru">prog@sp-ic.ru</a>.</p>

<p><strong>ВНИМАНИЕ!</strong><br />
В&nbsp;этом году конференция СПИК проходит в&nbsp;<nobr>10-й</nobr> юбилейный раз, и&nbsp;мы&nbsp;планируем побить рекорды по&nbsp;сбору участников мероприятия. Предлагаем вам присоединиться :)</p>

<p>Вам, как докладчику конференции, для приглашения ваших коллег, знакомых или ключевых клиентов предоставляется <strong>3&nbsp;промо-кода на&nbsp;бесплатное очное участие в&nbsp;СПИК 2015</strong>:</p>
<ul>
<?
	for ($i = 0; $i < 3; $i++) {
		$discount = new \pay\models\Coupon();
		$discount->EventId  = 1580;
		$discount->Code = $discount->generateCode();
		$discount->EndTime  = null;
		$discount->Discount = 1;
		$discount->save();
		echo "<li><b style='background-color: #FCD630; font-family: Courier; margin: 5px 0; padding: 3px 5px;'>" . $discount->Code . "</b></li>";
	}
?>
</ul>

<p>Вы&nbsp;можете по&nbsp;собственному усмотрению передать их&nbsp;потенциальным участникам. Но&nbsp;обращаем ваше особое внимание, что промо-коды индивидуальные, и&nbsp;их&nbsp;запрещено публиковать и&nbsp;открыто распространять в&nbsp;социальных сетях. Участник после регистрации на&nbsp;сайте конференции собственноручно активирует промо-код в&nbsp;своем Личном кабинете.</p>

<p>Также мы&nbsp;готовы сделать еще до&nbsp;5&nbsp;промо-кодов, если вы&nbsp;сможете разыграть их&nbsp;среди своих клиентов и/или на&nbsp;своей странице в&nbsp;соц. сетях.</p>

<p>Дополнительно предоставляем <strong>скидку в&nbsp;30%</strong> по&nbsp;промо-коду: <b style="  background-color: #FCD630; font-family: Courier; margin: 5px 0; padding: 3px 5px;"><?=$userCode?></b>. Этот промо-код можно публиковать в&nbsp;открытом доступе и&nbsp;рассылать коллегам и&nbsp;клиентам.</p>

<p>До&nbsp;встречи на&nbsp;конференции!</p>
