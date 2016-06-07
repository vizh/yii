<?php	
	$regLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<!DOCTYPE html>
<html style="margin: 0; padding: 0;">
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Сегодня – в среду 21 октября в 10:00 утра стартует Российская Интерактивная Неделя (Russian Interactive Week) – RIW 2015 и Выставка «ИНТЕРНЕТ 2015»</title>
</head>
<body bgcolor="#f6f6f6" style="-webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5em; margin: 0; padding: 0;">
<style type="text/css">
@media only screen and (max-width: 480px) {
  .content .img-right {
    float: none; height: auto; margin: 15px 0; width: 100%;
  }
  .full {
    display: block !important; width: 100% !important;
  }
  .full-hidden {
    display: none !important; height: 0 !important; width: 0% !important; visibility: hidden !important;
  }
}
</style>

	<div id="wrapper" style="height: 100%; width: 100%; background: #f6f6f6; margin: 0; padding: 0;">
		
		<!-- unboxed -->
		<table class="unboxed-wrap" bgcolor="#f6f6f6" style="clear: both !important; width: 100%; margin: 25px 0 0; padding: 25px 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		    <td class="container" style="vertical-align: top; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 0;" valign="top">
		      
		      <!-- content -->
		      <div class="content" style="display: block; max-width: 600px; margin: 0 auto; padding: 0;">
		        <table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td align="center" style="vertical-align: top; margin: 0; padding: 0;" valign="top">
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;"><?=$user->getShortName();?>, здравствуйте!</h3>
		              	<p class="lead" style="font-size: 17px; font-weight: normal; margin: 0 0 10px; padding: 0;">Главное осеннее событие отрасли высоких технологий (интернет, медиа, телеком и софт) – начинает свою работу сегодня</p>
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
					<a href="http://riw.moscow" style="line-height: 0 !important; color: #D85B42; margin: 0; padding: 0;"><img src="https://showtime.s3.amazonaws.com/201510201156-riw15-logo.jpg" style="height: auto; width: 100%; margin: 0; padding: 0;" alt=""></a>
				</td>
				<td style="vertical-align: top; line-height: 0 !important; margin: 0; padding: 0;" valign="top"></td>
			</tr>
<tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		    <td class="container" bgcolor="#FFFFFF" style="vertical-align: top; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 20px;" valign="top">

		      <!-- content -->
		      <div class="content" style="display: block; max-width: 600px; margin: 0 auto; padding: 0;">
		      <table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Сегодня — в среду<strong style="margin: 0; padding: 0;"> 21 октября в 10:00 утра</strong> стартует Российская Интерактивная Неделя (<a href="http://riw.moscow" style="color: #D85B42; margin: 0; padding: 0;">RIW 2015</a>), которая пройдет в московском Экспоцентре с 21 по 23 октября.</p>
					<div class="center" style="text-align: center; margin: 0; padding: 0;" align="center">
						<table style="text-align: left; width: auto; margin: 15px auto; padding: 0;"><tr style="margin: 0; padding: 0;">
<td valign="middle" width="55" style="vertical-align: top; margin: 0; padding: 3px;">
									<img src="http://showtime.s3.amazonaws.com/201506081226-badge_icon.png" style="height: auto; width: auto; max-width: 600px; margin: 0; padding: 0;">
</td>
								<td valign="middle" style="vertical-align: top; margin: 0; padding: 0;">
									Ваш статус:<br style="margin: 0; padding: 0;"><strong style="font-size: 120%; margin: 0; padding: 0;">
									<?
										if ($user->Participants[0]->Role->Title == 'Участник') {
											print 'Участник выставки';
										} else {
											print $user->Participants[0]->Role->Title;
										}
									?></strong>
								</td>
							</tr></table>
</div>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Зарегистрированным участникам Выставки «Интернет 2015» будут доступны все 3 дня: посещение выставки, залы Общей и Профессиональной программы RIW (в зависимости от <a href="http://riw.moscow/info/guide/" style="color: #D85B42; margin: 0; padding: 0;">статуса участника</a>), а также видео из этих залов.</p>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><b style="margin: 0; padding: 0;">Стойки регистрации</b> работают на площадке все 3 дня с утра до вечера. Для ускорения процесса регистрации рекомендуем заранее <a href="<?=$user->Participants[0]->getTicketUrl();?>" style="color: #D85B42; margin: 0; padding: 0;">распечатать путевой лист</a> или быть готовыми показать их с экрана мобильных устройств.</p>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><b style="margin: 0; padding: 0;">Для удобства навигации</b> на территории Выставки «Интернет 2015» можно воспользоваться <a href="http://riw.moscow/upload/RIW2015_expo-scheme.pdf" style="color: #D85B42; margin: 0; padding: 0;">картой выставки</a> в формате PDF.</p>
					<hr style="border-top-color: #eaeaea; border-top-style: solid; height: 1px; margin: 35px auto; padding: 0; border-width: 1px 0 0;">
<h3 class="center" style="text-align: center; color: #111111; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-weight: 200; line-height: 1.2em; font-size: 22px; margin: 10px 0; padding: 0;" align="center">Не пропустите открытие RIW</h3>
					<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;"><b style="margin: 0; padding: 0;">С 10:00 до 11:00</b> в Presentation Hall пройдет <a href="http://riw.moscow/program/2015-10-21/310/#s2534" style="color: #D85B42; margin: 0; padding: 0;">Открытие RIW 2015</a>, выставки Интернет 2015 и Softool 2015. В ходе открытия запланированы выступления организаторов и партнеров Недели, представителей государства и бизнеса: <b style="margin: 0; padding: 0;">только эксклюзив из первых уст</b>.</p>
		          </td>
		        </tr></table>
</div>
		      <!-- /content -->
		      
		    </td>
		    <td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		  </tr>
</table>
<!-- /body --><!-- body --><table class="body-wrap" bgcolor="#f6f6f6" style="border-collapse: collapse; width: 100%; margin: 0; padding: 20px;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		    <td class="container" bgcolor="#FFF9AD" style="vertical-align: top; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 20px;" valign="top">

		      <!-- content -->
		      <div class="content" style="display: block; max-width: 600px; margin: 0 auto; padding: 0;">
		      <table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
		          	<p style="font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;">Для тех, кто не сможет посетить все мероприятия RIW 2015 — онлайн-кинотеатр TVzavr.ru представляет эксклюзивную онлайн-трансляцию главных событий из двух главных залов программы RIW 2015.</p>
		          	<!-- button -->
		            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="width: auto; margin: 25px auto 10px; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; text-align: center; background: #D85B42; margin: 0; padding: 0;" align="center" bgcolor="#D85B42" valign="top">
		                  <a href="http://riw.moscow/online/" style="color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; line-height: 2; text-decoration: none; background: #D85B42; margin: 0; padding: 0; border-color: #d85b42; border-style: solid; border-width: 10px 20px;">ОНЛАЙН-ТРАНСЛЯЦИЯ</a>
		                </td>
		              </tr></table>
<!-- /button -->
</td>
		        </tr></table>
</div>
		      <!-- /content -->
		      
		    </td>
		    <td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		  </tr></table>
<!-- /body --><!-- body --><table class="body-wrap" bgcolor="#f6f6f6" style="border-collapse: collapse; width: 100%; margin: 0; padding: 20px;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		    <td class="container" bgcolor="#FFFFFF" style="vertical-align: top; clear: both !important; display: block !important; max-width: 600px !important; margin: 0 auto; padding: 20px;" valign="top">

		      <!-- content -->
		      <div class="content" style="display: block; max-width: 600px; margin: 0 auto; padding: 0;">
		      <table style="width: 100%; margin: 0; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; margin: 0; padding: 0;" valign="top">
					<p class="center lead" style="font-size: 17px; text-align: center; font-weight: normal; margin: 0 0 10px; padding: 0;" align="center">В личном кабинете вы имеете возможность приобрести статус «Профессиональный участник» для Вас и Ваших коллег</p>
	              	<!-- button -->
		            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="width: auto; margin: 25px auto 10px; padding: 0;"><tr style="margin: 0; padding: 0;">
<td style="vertical-align: top; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; text-align: center; background: #D85B42; margin: 0; padding: 0;" align="center" bgcolor="#D85B42" valign="top">
		                  <a href="<?=$regLink?>" style="color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; line-height: 2; text-decoration: none; background: #D85B42; margin: 0; padding: 0; border-color: #d85b42; border-style: solid; border-width: 10px 20px;">ЛИЧНЫЙ КАБИНЕТ</a>
		                </td>
		              </tr></table>
<!-- /button --><p class="center" style="text-align: center; font-size: 14px; font-weight: normal; margin: 0 0 10px; padding: 0;" align="center">До встречи на главном мероприятии осени – RIW 2015!</p>
		          </td>
		        </tr></table>
</div>
		      <!-- /content -->
		      
		    </td>
		    <td style="vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
		  </tr></table>
<!-- /body -->
</div>

</body>
</html>
