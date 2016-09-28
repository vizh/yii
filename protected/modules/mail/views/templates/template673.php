<?php

	$product = \pay\models\Product::model()->findByPk(3845);
	$coupon = new \pay\models\Coupon();
  	$coupon->EventId = 1935;
  	$coupon->Discount = 20;
  	$coupon->Code = $coupon->generateCode();
  	$coupon->EndTime = null;
  	$coupon->save();
	$coupon->addProductLinks([$product]);

	$regLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html>
<html style="margin: 0; padding: 0;">
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Мы знаем, что Вы являетесь постоянным участником профессиональных конференций и мероприятий Рунета, таких как РИФ+КИБ, RIW и другие</title>
</head>
<body bgcolor="#f6f6f6" style="-webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.5em; margin: 0; padding: 0;">

	<div id="wrapper" style="height: 100%; width: 100%; background: #f6f6f6; margin: 0; padding: 0;">

		<!-- unboxed -->
		<table class="unboxed-wrap" bgcolor="#f6f6f6" style="clear: both !important; width: 100%; margin: 25px 0 0; padding: 25px 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		    <td class="container" style="vertical-align: top; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 0;" valign="top">

		      <!-- content -->
		      <div class="content" style="display: block; max-width: 600px; margin: 0 auto; padding: 0;">
		        <table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td align="center" style="vertical-align: top; margin: 0; padding: 0;" valign="top">
		              	<h2 style="color: #111111; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-weight: 200; line-height: 1.2em; font-size: 28px; margin: 10px 0; padding: 0;"><?=$user->getShortName()?>, здравствуйте!</h2>
						<p class="lead" style="font-size: 17px; font-weight: normal; margin: 0 0 10px; padding: 0;">Чуть меньше месяца остается до Russian Interactive Week – RIW 2015 – <a href="http://www.RIW.moscow" style="color: #D85B42; margin: 0; padding: 0;">www.RIW.moscow</a></p>
						<p class="lead" style="font-size: 17px; font-weight: normal; margin: 0 0 10px; padding: 0;">RIW 2015 пройдет 21-23 октября в московском Экспоцентре.</p>
		            </td>
		          </tr></table>
</div>
		      <!-- /content -->

		    </td>
		    <td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		  </tr></table>
<!-- /unboxed --><!-- body --><table class="body-wrap" bgcolor="#f6f6f6" style="border-collapse: collapse; width: 100%; margin: 0; padding: 20px;">
<tr class="clear-padding" style="margin: 0; padding: 0;">
<td style="vertical-align: top; line-height: 0 !important; margin: 0; padding: 0;" valign="top"></td>
				<td class="container-image" style="vertical-align: top; clear: both !important; display: block !important; max-width: 642px !important; line-height: 0 !important; margin: 0 auto; padding: 0;" valign="top">
					<a href="http://riw.moscow" style="line-height: 0 !important; color: #D85B42; margin: 0; padding: 0;"><img src="https://showtime.s3.amazonaws.com/201509170846-riw15.jpg" style="height: auto; width: 100%; margin: 0; padding: 0;" alt=""></a>
				</td>
				<td style="vertical-align: top; line-height: 0 !important; margin: 0; padding: 0;" valign="top"></td>
			</tr>
<tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		    <td class="container" bgcolor="#FFFFFF" style="vertical-align: top; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;" valign="top">

		      <!-- content -->
		      <div class="content" style="display: block; max-width: 600px; margin: 0 auto; padding: 0;">
		      <table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
					<p class="lead" style="font-size: 17px; font-weight: normal; margin: 0 0 10px; padding: 0;">Мы знаем, что Вы являетесь постоянным участником профессиональных конференций и мероприятий Рунета, таких как РИФ+КИБ, RIW и МКФ.</p>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><b style="margin: 0; padding: 0;">Приглашаем вас посетить главные события отечественной интернет-индустрии</b> — выставку и форум RIW 2015, которые пройдут в Экспоцентре на Красной Пресне с 21 по 23 октября 2015 года.</p>
					<div class="border" style="margin: 0 0 15px; padding: 25px 25px 15px; border: 1px solid #d65c47;">
						<table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
									<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Персонально для Вас <b style="margin: 0; padding: 0;">специальные условия участия</b> в главном осеннем мероприятии сразу четырех отраслей (интернет, медиа, телеком и софт) Russian Interactive Week 2015: <b style="margin: 0; padding: 0;">скидку –20% на профессиональное участие</b>.</p>
									<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><?=$user->getShortName()?>, ваш персональный промо-код на 20% скидку:<br style="margin: 0; padding: 0;"><b style="color: #D85A43; font-size: 28px; margin: 0; padding: 0;"><?=$coupon->Code?></b></p>
									<p style="color: #999; line-height: 14px; font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><small style="margin: 0; padding: 0;">Данный промо-код является уникальным и может быть активирован в личном кабинете на сайте RIW-2015 только один раз.</small></p>
								</td>
								<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
									<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><b style="font-size: 84px; color: #D85A43; line-height: 84px; display: inline-block; margin: 5px 20px; padding: 0;">%</b></p>
								</td>
							</tr></table>
</div>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Говорят, кризис — это время возможностей, ведь именно в этот период самым ярким образом проявляются предпринимательские качества бизнесменов. Рунет даже в период общего стагнирования экономики показывает результаты, которые можно назвать более чем выдающимися. Поезд разгоняется и если вы всё ещё стоите на перроне, то самое время начать двигаться по пути развития. Так как коммуникации на рынке играют огромную роль.</p>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Уже сейчас вы можете познакомиться с <a href="http://riw.moscow/program/" style="color: #D85B42; margin: 0; padding: 0;">программой форума</a> и выбрать для себя самые интересные секции.</p>
					<hr style="border-top-color: #eaeaea; border-top-style: solid; height: 1px; margin: 35px auto; padding: 0; border-width: 1px 0 0;">
<h4 style="font-size: 18px; margin: 0 0 10px; padding: 0;">Регистрация участия</h4>
					<table style="width: 100%; margin: 0; padding: 0;">
<tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
								<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Посещение Выставки «ИНТЕРНЕТ 2015» и Softool 2015 — бесплатно все 3 дня для зарегистрированных участников</p>
							</td>
							<td style="width: 20px; vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
							<td style="width: 180px; vertical-align: top; margin: 0; padding: 0;" valign="top">
								<!-- button -->
					            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="width: 100%; margin: 0 0 10px; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; text-align: center; background: #D85B42; margin: 0; padding: 0;" align="center" bgcolor="#D85B42" valign="top">
					                  <a href="<?=$regLink?>" style="color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; line-height: 2; text-decoration: none; background: #D85B42; margin: 0; padding: 0; border-color: #d85b42; border-style: solid; border-width: 10px 20px;">БЕСПЛАТНО</a>
					                </td>
					              </tr></table>
<!-- /button -->
</td>
						</tr>
<tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
								<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Профессиональная программа (9 залов, более 20 блок-конференций, доступ в Бизнес-зону).</p>
							</td>
							<td style="width: 20px; vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
							<td style="width: 180px; vertical-align: top; margin: 0; padding: 0;" valign="top">
								<!-- button -->
					            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="width: 100%; margin: 0 0 10px; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; text-align: center; background: #D85B42; margin: 0; padding: 0;" align="center" bgcolor="#D85B42" valign="top">
					                  <a href="<?=$regLink?>" style="color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; line-height: 2; text-decoration: none; background: #D85B42; margin: 0; padding: 0; border-color: #d85b42; border-style: solid; border-width: 10px 20px;">РЕГИСТРАЦИЯ</a>
					                </td>
					              </tr></table>
<!-- /button -->
</td>
						</tr>
</table>
</td>
		        </tr></table>
</div>
		      <!-- /content -->

		    </td>
		    <td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		  </tr>
</table>
<!-- /body -->
</div>

</body>
</html>
