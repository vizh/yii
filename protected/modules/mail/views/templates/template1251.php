<?php
$discount = new \pay\models\Coupon();
$discount->EventId  = 3027;
$discount->Code = $discount->generateCode();
$discount->EndTime  = null;
$discount->Discount = 100;
$discount->save();

$product = \pay\models\Product::model()->findByPk(6188);
$discount->addProductLinks([$product]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ваше персональное приглашение и ПРОМО-КОД для участия в конференции “Рунет 2016: Итоги года” </title>
        <style type="text/css">
            body {
                margin: 0;
                padding: 0;
                min-width: 100%!important
            }
            td {
                font-family: 'Open Sans', Helvetica, Arial, sans-serif;
                font-size: 14px
            }
            .content {
                width: 100%;
                max-width: 600px;
                position: relative
            } 
            .wrapper {
                padding: 20px
            }
            .section-white {
                background-color: #ffffff
            }
            .head-img {
                width: 100%;
				display: block
            }       
            .h2 {
              color: #111111;
              font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
              font-weight: 200;
              line-height: 1.2em;
              margin: 10px 0;
              font-size: 28px
            }
 			.black-a {
	 			color: #000000
 			}
 			.blue-a {
	 			color: #005580;
 			}
 			.big-text {
	 			font-size: 18px
 			}
  			.btn-blue {
	 			font-size: 16px;
	 			padding: 10px 20px;
	 			text-decoration: none;
	 			display: inline-block;
	 			margin: 10px 0;
	 			text-transform: uppercase;
	 			background-color: #005580;
	 			color: #FFFFFF;
	 			font-weight: bold
 			}
 			.blue {
	 			color: #005580
 			}
 			ol li {
	 			margin-bottom: 10px;
 			}
			.hr-gray {
	 			background-color: #E2E2E2;
	 			border: none;
	 			border-top: solid 1px #E2E2E2;
	 			margin: 20px 0
			} 		
            @media only screen and (min-device-width: 601px) {
                .content {
	                width: 600px !important
	            }
            }
            @media screen and (max-width: 600px) {
                .content {
	                width: 100%!important
	            }
            }
		</style>
        <!--[if (gte mso 9)|(IE)]>
        	<style>
	            td {
	                font-family: Helvetica, Arial, sans-serif;
	            }
        	</style>
        <![endif]-->                                                
    </head>
    <body yahoo bgcolor="#F1F1F1">
        <table width="100%" bgcolor="#F1F1F1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
            <tr>
                <td>
                    <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <![endif]-->                                
                                <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
	                                <tr>
	                                    <td class="wrapper">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" class="h2">Здравствуйте, <?=$user->getShortName()?>!</td>
                                                </tr>
                                            </table>
										</td>
	                                </tr>
                                </table>
                                <!--[if (gte mso 9)|(IE)]>
                            </td>
                        </tr>
                    </table>
                    <![endif]-->

                    <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <![endif]-->
                                <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0">
                                    <tr class="wrapper">
                                        <td valign="top">
	                                        <img src="http://vizh.share.s3.amazonaws.com/ruvents/runet2016/runet-itogi-top.jpg" width="600" class="head-img" />
                                        </td>
                                    </tr>
                                </table>
                                <!--[if (gte mso 9)|(IE)]>
                            </td>
                        </tr>
                    </table>
                    <![endif]-->
                    <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <![endif]-->
                                <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0">
	                                <tr>
	                                    <td class="wrapper section-white" style="padding-bottom: 10px">
	                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							                    <!--[if (gte mso 9)|(IE)]>
							                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							                        <tr>
							                            <td height="1" style="padding:0; margin: 0">
							                            </td>
							                        </tr>
							                    </table>
							                    <![endif]-->                                                
                                                <tr>
	                                                <td>
		                                                <p>14 декабря в&nbsp;Digital October на&nbsp;Красном Октябре пройдет ежегодная конференция &laquo;Рунет 2016: Итоги года&raquo;, в&nbsp;этом году под эгидой &laquo;Курс&nbsp;&mdash; на&nbsp;цифровую экономику России&raquo;.</p>
														<p class="big-text" align="center"><b>Приглашаем Вас принять участие в&nbsp;конференции</b></p>
														<p>Поскольку Вы активно принимали участие в мероприятиях, прошедших в&nbsp;этом году при поддержке РАЭК в&nbsp;этом году &mdash; <span>для Вас предусмотрена <a href="" class="big-text black-a">бесплатная регистрация</a> на&nbsp;конференцию 14 декабря</span>.</p>
														<p align="center"><b>Для того чтобы пройти регистрацию, Вам необходимо:</b></p>
														<ol>
															<li>Перейти по&nbsp;ссылке <a href="<?=$user->getFastAuthUrl('https://runet-id.com/event/itogi2016');?>" target="_blank">к форме регистрации</a></li>
															<li>Ввести при регистрации Ваш персональный <nobr>ПРОМО-КОД</nobr> на&nbsp;100% скидку: <span style="background: yellow; display: inline-block; padding: 1px 3px;"><?=$discount->Code?></span></li>
														</ol>
														<p align="center"><a href="<?=$user->getFastAuthUrl('https://runet-id.com/event/itogi2016');?>" target="_blank" class="btn-blue">Регистрация в&nbsp;один клик</a></p>
														<p>Если у&nbsp;Вас есть дополнительные вопросы относительно участия&nbsp;&mdash; пишите на&nbsp;<a href="mailto:itogi2016@raec.ru" class="black-a">itogi2016@raec.ru</a></p>
														<p>До&nbsp;встречи на&nbsp;конференции <a href="<?=$user->getFastAuthUrl('https://runet-id.com/event/itogi2016');?>" target="_blank" class="black-a">&laquo;Рунет 2016: итоги года&raquo;</a>!</p>
													</td>	                                                
                                                </tr>
	                                        </table>
										</td>
	                                </tr>
                                </table>
                                <!--[if (gte mso 9)|(IE)]>
                            </td>
                        </tr>
                    </table>
                    <![endif]-->	 
               </td>
            </tr>
        </table>

    </body>
</html>