<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
<style>.btn-primary {
	text-decoration: none;
	color: #FFF;
	background-color: #9e1869;
	border: solid #9e1869;
	border-width: 10px 20px;
	line-height: 2;
	font-weight: bold;
	margin-right: 10px;
	text-align: center;
	cursor: pointer;
	display: inline-block;
	border-radius: 25px;
}</style>
  </head>
  <body bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">

 <table class="body-wrap" bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
		<td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

			<!-- content -->
			<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
			<!--[if (gte mso 9)|(IE)]>
<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<![endif]-->
<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">

	 
<p><a href="http://ruvents.com/" target="_blank"><img src="http://getlogo.org/img/ruvents/540/200x/" alt="RUVENTS" title="RUVENTS" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 100%; margin: 0; padding: 0; width: 200px;"  /></a><p style="line-height: 25px;"></p>

<p><hr/ style="border:0;border-bottom: 1px solid #eaeaea; margin-top: 25px;"></p>

<h2 style=" font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 28px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Уважаемые коллеги,<br/>друзья и, верим, будущие партнеры!</h2>

<p style="font-size: 15px; line-height: 25px;">Сначала мы хотели в этом письме направить Вам наше коммерческое предложение. Но подумали, что это будет слишком скучно или даже воспринято как спам, и решили сделать Вам необычное предложение.</p>

<table border="0" width="100%" style="background-color: #F6F6F6;">
	<tr>
		<td width="30%" style="padding: 15px 25px">
			<?
				for ($i = 0; $i < 1; $i++) {
					$discount = new \pay\models\Coupon();
					$discount->EventId  = 3016;
					$discount->Code = 'RUV' . $discount->generateCode();
					$discount->EndTime  = null;
					$discount->Discount = 100;
					$discount->save();
					$product = \pay\models\Product::model()->findByPk(9270);
					$discount->addProductLinks([$product]);
					echo "<b>" . $discount->Code . "</b><br/>";
				}
			?>
            <small style="color: #777; font-size: 8px; line-height: 13px; display: block;">Если вам нужен второй пригласительный - сообщите :-)</small>
		</td>
		<td width="70%" style="padding: 15px 25px">
			Ваш персональный пригласительный на РИФ+КИБ 2017, который активируются в <a href="http://2017.russianinternetforum.ru/registration/">личном кабинете</a>
		</td>
	</tr>
</table>

<p style="line-height: 25px;">Мы хотим предложить Вам бесплатно получить доступ к новым клиентам или партнерам, множеству интересных докладов и аналитики, возможности отлично провести время и заодно оценить уровень нашей работы на главном мероприятии Рунета &ndash; &laquo;РИФ+КИБ 2017&raquo;, которое пройдет уже на следующей неделе с 19 по 21 апреля 2017 года. Мероприятие платное, но друзья RUVENTS имеют уникальный шанс попасть на него бесплатно: 1-2 человек из Вашей команды могут воспользоваться нашим предложением.</p>

<p style="line-height: 25px;"><b>Почему мы дарим Вам посещение одного из самых массовых и интересных мероприятий в Рунете?</b> Именно такое масштабное событие даёт наилучшее представление о нашей работе: если мы не заметны, значит, организаторы и гости довольны.</p>

<p style="line-height: 25px;">Мы &ndash; это команда RUVENTS, предоставляющая полный комплекс услуг по встрече и регистрации гостей на мероприятиях, организации интерактивных сервисов на площадке, созданию систем контроля доступа и сбору информации об активностях участников.</p>

<p style="line-height: 25px;">Вам не нужно с нами встречаться (только если Вы сами этого захотите), Ваша задача &ndash; получить новые знания, эмоции и контакты на самом мероприятии, которое за три дня планируют посетить 8000-10 000 владельцев бизнесов, маркетологов, PR-щиков, руководителей медиа, ведущих аналитиков IT-отрасли, электронной коммерции, RTB и т.д. &ndash; всех тех, кто ищет эксклюзивный контент и новые тренды.</p>

<p style="line-height: 25px;">Все, что нам необходимо: по итогам мероприятия мы будем ждать Вашу оценку того, насколько мы были профессиональны: все ли гости были встречены, каждому был вручен бейдж и промо-материалы и т.д. Мы, в свою очередь, обещаем поделиться подробной аналитикой о мероприятии: какие мастер-классы пользовались повышенным спросом, что гостей и участников заинтересовало больше всего (мы ведем всю статистику в он-лайн режиме).</p>

<p>Собственно все, осталось только поделиться контактами и ссылками.</p>

<p>Представление о самом мероприятии можно получить на <a href="http://www.rif.ru">официальном сайте</a>, а зарегистрировать себя и своих представителей с указанными выше промо-кодами можно в <a href="http://2017.russianinternetforum.ru/registration/">личном кабинете</a>.</p>

<p>По этому телефону Вы сможете связаться с нами (если захотите) во время мероприятия:<br/>+7 (495) 109-0200</p>

<p>По этому E-mail ждем Ваш отзыв о нашей работе: <a href="mailto:event@ruvents.com">event@ruvents.com</a></p>

<p>Желаем Вам отлично провести время &laquo;РИФ+КИБ 2017&raquo; - мероприятии, которое позволит Вам больше узнать и о нашей работе.</p>

<p><hr/ style="border:0;border-bottom: 1px solid #eaeaea;"></p>

<p><em>С наилучшими пожеланиями, команда RUVENTS!</em></p>
                        
                        
                        
                        
                                                                                </td>
                            </tr></table></td>
				</tr></table></div>
				<!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
			<!-- /content -->

		</td>
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
	</tr></table></body>
</html>


