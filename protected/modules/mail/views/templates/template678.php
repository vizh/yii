<?php
/**
 * @var \user\models\User $user
 */

$authHash = substr(md5('neObCDNjEsahftA~jCk*bAvi$0Es{c' . $user->RunetId), 0, 16);
$authUrl  = 'http://reg.premiaruneta.ru/cabinet/auth/?id=' . $user->RunetId . '&hash=' . $authHash . '&redirectPath=/';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Продолжается прием заявок на соискание 12-й Национальной премии за вклад в развитие российского сегмента сети Интернет – ПРЕМИИ РУНЕТА 2015</title>
  </head>
  <body bgcolor="#000000" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; background: #000000; margin: 0; padding: 0;"><style type="text/css">
@media (max-width: 400px) {
  .chunk {
    width: 100% !important;
  }
}
</style>

<!-- body -->
<table bgcolor="#000000" class="body-wrap" style="background: #000000; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
    <td class="container" bgcolor="#000000" border="0" style="background: #000000; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0; border: 0;">
      <!-- header -->
      <img src="https://showtime.s3.amazonaws.com/201509100149-premiaru15-background.jpg" style="height: auto; width: 100%; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; max-width: 100%; margin: 0; padding: 0;" /></td>
    <td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
  </tr><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
		<td class="container" bgcolor="#FFFFFF" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px;">
			<!-- content -->
			<div class="content" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
			<table style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
			            <h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Здравствуйте, <?=$user->getShortName();?>!</h3>
			            <p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Продолжается прием заявок на соискание <nobr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12-й</nobr> Национальной премии за вклад в развитие российского сегмента сети Интернет — <a href="http://www.PremiaRuneta.ru" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; color: #000000; margin: 0; padding: 0;">ПРЕМИИ РУНЕТА 2015</a>.</p>
						<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Подать заявку на участие могут организации и интернет-проекты (представленные юридическими лицами), внесшие особый вклад в развитие Рунета в <nobr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">2014–2015 годах.</nobr></p>
						
						<p class="center" style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; text-align: center; font-weight: normal; margin: 15px 0 20px; padding: 0;" align="center"><a href="<?=$authUrl?>" class="btn-primary" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.2; color: #000; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; text-transform: uppercase; background: #fff; margin: 0 auto; padding: 12px 65px; border: 2px solid #000;">НОМИНИРОВАТЬСЯ</a></p>

						<hr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #eaeaea; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><img src="http://files.runet-id.com/2014/premiaru/photo/ceremony/premia14-ceremony_011_480.jpg" style="height: auto; width: 100%; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; max-width: 100%; margin: 0; padding: 0;" /></p>
						
						<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;">Премия Рунета 2015 вручается вручаться в шести основных, трех специальных номинациях и трех номинациях Народного голосования:</p>
						<table style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; width: 50%; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" valign="top">
									<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Основные номинации:</strong></p>
									<ul style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Инновации и Технологии</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Экономика, Бизнес и Инвестиции</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Государство и общество</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Культура, СМИ и Массовые коммуникации</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Наука и Образование</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Здоровье, Развлечения и Отдых</li>
									</ul></td>
								<td style="vertical-align: top; width: 50%; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" valign="top">
									<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Специальные номинации:</strong></p>
									<ul style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">За развитие региональных интернет-проектов</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Интернет без экстремизма</li>
										<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Лучший проект в доменной зоне .SU</li>
									</ul></td>
							</tr></table><p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Народное голосование:</strong></p>
						<ul style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Народный Интернет-проект</li>
							<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Сообщество Рунета</li>
							<li style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 5px 35px; padding: 0; list-style: outside;">Народная Игра Рунета</li>
						</ul><h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Условия номинирования и участия</h3>
						<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Участие в Конкурсе «Премия Рунета» платное. Стоимость подачи заявки составляет <strong style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">10 000 рублей за одну заявку</strong> в одной номинации. Суммы взносов идут на организацию конкурсного отбора победителей, информационное сопровождение конкурса, в том числе информирование общественности о номинантах, их вкладе в развитие интернет-сообщества, достижениях в профессиональной сфере, а также на организацию Церемонии награждения.</p>
						<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Для ряда категорий номинантов (социально-ориентированные и социально-значимые проекты, некоммерческие организации и их проекты, а также специальные ресурсы и проекты, отнесенные к льготной категории решением Оргкомитета) предусмотрено <strong style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">номинирование без оплаты</strong> заявки, по итогам ее рассмотрения Оргкомитетом.</p>

						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">О Премии Рунета</h3>
						<img src="https://showtime.s3.amazonaws.com/201510050912-premiaru15-statuette.png" style="float: right; font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 0 0 10px 10px; padding: 0;" align="right" /><p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Премия Рунета является общенациональной наградой в области высоких технологий и интернета, поощряющей выдающиеся заслуги компаний-лидеров в области информационных технологий и электронных коммуникаций, государственных и общественных организаций, бизнес-структур, а также отдельных деятелей, внесших значительный вклад в развитие российского сегмента сети Интернет (Рунета). </p>
						<p style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Премия Рунета присуждается в <nobr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12-й</nobr> раз, с 2004 года. За это время лауреатами Премии Рунета стали более 250 организаций.</p>
					</td>
				</tr></table></div>
			<!-- /content -->
			
		</td>
		<td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
	</tr></table><!-- /body --></body>
</html>
