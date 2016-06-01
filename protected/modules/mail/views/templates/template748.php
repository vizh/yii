<?php
/**
 * @var \user\models\User $user
 */
$event = \event\models\Event::model()->findByPk(2000);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
  </head>
  <body bgcolor="#000000" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; background: #000000; margin: 0; padding: 0;"><style type="text/css">
@media (max-width: 400px) {
  .chunk {
    width: 100% !important;
  }
}
</style>

<!-- body -->
<table class="body-wrap" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
    <td class="container" bgcolor="#000000" border="0" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0; border: 0;">
      <!-- header -->
      <img src="https://showtime.s3.amazonaws.com/201509100149-premiaru15-background.jpg" style="height: auto; width: 100%; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; max-width: 100%; margin: 0; padding: 0;" /></td>
    <td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
  </tr><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
		<td class="container" bgcolor="#FFFFFF" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px;">
			<!-- content -->
			<div class="content" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
			<table style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; vertical-align: top; width: 100%; margin: 0; padding: 0;"><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; vertical-align: top; margin: 0; padding: 0;" valign="top">
			            <h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;"><?=$user->getShortName();?>, здравствуйте!</h3>
			            
			            <p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Напоминаем, что Вы сообщили о желании принять участие в качестве гостя в Торжественной церемонии вручения Премии Рунета 2015!</p>
<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Мероприятие состоится завтра, <strong>10 ноября &nbsp;2015 года в кинотеатре &laquo;Октябрь&raquo; (ул. Новый Арбат, д.24, второй этаж, Большой зал)</strong></p>
<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong>Сбор гостей – с 17:30, начало Церемонии – ровно в 19:30.</strong></p>

<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Подробно о церемонии награждения: <a href="http://premiaruneta.ru/ceremony/">http://premiaruneta.ru/ceremony/</a></p>

<hr />

<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong>ВНИМАНИЕ!</strong></p>


<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Пожалуйста, не забудьте распечатать и сохранить на мобильном устройстве Ваш персональный пригласительный билет и предъявить его при входе на площадку:</p>

<p align="center" style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="<?=$user->Participants[0]->getTicketUrl();?>" class="btn-primary" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.2; color: #000; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; text-transform: uppercase; background: #fff; margin: 0 auto; padding: 12px 65px; border: 2px solid #000;">ПРИГЛАСИТЕЛЬНЫЙ БИЛЕТ</a></p>



							
									<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Контроль пригласительных билетов будет осуществляться внутри к/т Октябрь, на лестнице между первым и вторым этажами кинотеатра. Рекомендуем проходить контроль после посещения гардероба, расположенного на первом этаже.</p>


<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><b style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Желаем вам отличного настроения, позитивных эмоций и дружеского общения! 
До встречи на Церемонии!</b> 								


						<p align="center" style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><small style="font-family: Verdana, Geneva, sans-serif; font-size: 11px; line-height: 1.6; margin: 0; padding: 0;">Оргкомитет конкурса “Премия Рунета” 
<br style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><a href="http://www.premiaruneta.ru" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; color: #000000; margin: 0; padding: 0;">www.PremiaRuneta.ru</a></small></p>

					</td>
				</tr></table></div>
			<!-- /content -->
			
		</td>
		<td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
	</tr></table><!-- /body --></body>
</html>
