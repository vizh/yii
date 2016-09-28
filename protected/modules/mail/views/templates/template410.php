<?php
	$coupon = new \pay\models\Coupon();
	$coupon->EventId = 1534;
	$coupon->Code = $coupon->generateCode();
	$coupon->Discount = 0.25;
	$coupon->save();
	$coupon->addProductLinks([\pay\models\Product::model()->findByPk(3081)]);
	$coupon->save();
	$coupon->activate($user, $user);
	$regLink = "http://2015.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'aihrQ0AcKmaJ'), 0, 16);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Вы уже наверное знаете, что РИФ+КИБ 2015 пройдет 22–24 апреля на площадках пансионатов “Поляны”, а также “Лесные дали” и “Назарьево” </title>
  </head>
  <body bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; background: url('http://showtime.s3.amazonaws.com/20150325-rif15-email_bg.jpg') center; margin: 0; padding: 0;">

<!-- body -->
<table class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"></td>
		<td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; display: block !important; max-width: 550px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

			<!-- content -->
			<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; max-width: 550px; display: block; margin: 0 auto; padding: 0;">
			<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">
						<h3 align="center" style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 10px 0; padding: 0;">Здравствуйте, <?=$user->getShortName()?>.</h3>

						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Вы уже наверное знаете, что РИФ+КИБ 2015 пройдет <nobr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">22–24</nobr> апреля на площадках пансионатов «Поляны» (основная конференционная и выставочная площадка), а также «Лесные дали» и «Назарьево» (дополнительные площадки, задействованные для проживания участников РИФ+КИБ).</p>
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">А мы знаем, что <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">вы являетесь постоянным участником РИФ+КИБ</strong>.</p>
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">И пожалуй, нам пора создать «доску почета» и вывесить всех кто столько лет подряд верен проекту, который в этом году пройдет в 19 раз.</p>
						<div class="bordered center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; text-align: center; margin: 15px 0; padding: 25px; border: 1px solid #1ba669;" align="center">
							<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">В знак благодарности, <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">дарим вам скидку 25%</b>,<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;" />которая уже активирована на ваш профиль. </p>
						</div>
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Для активации специальных условий никаких дополнительных действий не требуется. Просто войдите в личный кабинет по персональной ссылке ниже и стоимость регистрационного взноса будет пересчитана!</p>
						<p align="center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><a href="<?=$regLink?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 2; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; background: #1BA669; margin: 0 10px 0 0; padding: 0; border-color: #1ba669; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
						<hr style="border-top-color: #eaeaea; border-top-style: solid; height: 1px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; border-bottom-style: solid; border-bottom-color: #eaeaea; width: 100%; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">Все три дня работы для вас будут доступны:</strong></p>
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Конференция (основная программа и Программа 2.0)</p>
							</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Выставка</p>
							</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Внепрограммные мероприятия и Программа +</p>
							</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Культурно-развлекательные мероприятия</p>
							</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Чистый воздух и море позитива</p>
							</li>
						 </ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">Ключевые темы программы РИФ+КИБ 2015:</strong></p>
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Есть ли кризис в Рунете? </p>
						 	</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Новые рекламные технологии </p>
						 	</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Региональный интернет </p>
						 	</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Электронная коммерция </p>
						 	</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Цифровая грамотность и образрвание </p>
						 	</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Информационная безопасность </p>
						 	</li>
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0 0 0 20px; padding: 0; list-style: outside;">
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Performance маркетинг и многое другое</p>
						 	</li>
						 </ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"> <a href="http://2015.russianinternetforum.ru/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Программа форума</a> обновляется несколько раз в день и доступна на официальном сайте.</p>
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">Также, если вы являетесь обладателем Runet-ID карты — не забудьте ее, она позволит вам сэкономить время на регистрации.</p>

						<hr style="border-top-color: #eaeaea; border-top-style: solid; height: 1px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; border-bottom-style: solid; border-bottom-color: #eaeaea; width: 100%; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><div style="color: #A6A6A6; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"><i style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">С уважением,<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;" />Оргкомитет РИФ+КИБ 2015</i></div>
						<div style="float: right; font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"><a href="mailto:users@rif.ru" style="color: #A6A6A6; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">users@rif.ru</a><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;" /><a href="http://www.rif.ru" style="color: #A6A6A6; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">www.rif.ru</a></div>
						<div style="float: left; font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"><a href="tel:+79999977890" style="color: #A6A6A6; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">+7 (999) 997-7890</a><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;" /><a href="tel:+79999910745" style="color: #A6A6A6; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;">+7 (999) 991-0745</a></div>
					</td>
				</tr></table></div>
			<!-- /content -->

		</td>
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 0;"></td>
	</tr></table><!-- /body --></body>
</html>
