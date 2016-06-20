<?php

$eventId = 2532;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 1;
$invite->Code = $code;
$invite->save();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Приглашение войти в Экспертный Совет ИРИ – по итогам 2016 года</title>
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

<!-- body -->
<table class="body-wrap" bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
    <td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

        <!-- content -->
        <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
            <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
                <img src="https://showtime.s3.amazonaws.com/201508121146-iri_logo" alt="ИРИ - Институт развития интернета" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 100%; margin: 0; padding: 0;" />
                
                
                
                

<h3>Здравствуйте <?=$user->getShortName();?>!</h3>

<p>Благодарим Вас за вклад в развитие Интернета и сообщаем, что по итогам работы отборочной комиссии Института Развития Интернета Вы вошли в состав экспертов 2016 года.</p>

<p>Приглашаем Вас на установочное Собрание экспертов ИРИ, которое состоится <strong>3 марта 2016 года в 11:00</strong> по адресу: Москва, ул. Льва Толстого, 16, штаб-квартира &laquo;Яндекс&raquo;, зал &laquo;Экстрополис&raquo;.</p>

<p><strong>Цель мероприятия:</strong> подведение итогов работы Экспертного Совета ИРИ в 2015-м году, презентация планов ИРИ на 2016-й год.</p>

<div style="border: 1px solid #7F1B6F; padding: 0 25px;">

<p><b>Для аккредитации на мероприятие</b> просим  подтвердить участие до 14:00 2 марта 2016, для этого нужно:</p>
<ol>
	<li><p>Перейти на <a href="<?=$user->getFastAuthUrl('/event/irief16/');?>"><b>страницу мероприятия</b></a></p></li>
	<li><p>Активировать персональный код приглашения: <span style="background: rgb(255, 231, 141); display: inline-block; padding: 1px 3px;"><b><?=$code?></b></span></p></li>
</ol>

</div>

<p><strong>В 2015 году</strong> Институт Развития Интернета представил свои предложения для формирования долгосрочной Программы развития Рунета. 21-22 декабря на <a href="http://ie.iri.center/">Российском Форуме &laquo;Интернет Экономика&raquo;</a>, который был высоко оценен Президентом РФ Владимиром Путиным, состоялось публичное обсуждение предложений экспертов ИРИ. Данные предложения легли в основу проектов дорожных карт по 8 направлениям И+: Общество, Образование, Торговля, Город, Медицина, Финансы, Медиа; ИТ+Суверенитет.</p>

<p><b>В 2016 году</b> в рамках ИРИ сформированы 8 профильных комитетов для дальнейшей работы. На следующей неделе мы отдельно пришлем письмо со списком комитетов, чтобы вы смогли  выбрать свой профильный комитет. Все дополнительные предложения просьба направлять на рассмотрение в ИРИ, через <a href="http://xn--h1aax.xn--p1ai/contacts/">форму обратной связи</a> на сайте ИРИ.</p>

<p>Будем рады видеть Вас 3 марта в 11.00 по адресу: Москва, ул. Льва Толстого, 16, штаб-квартира &laquo;Яндекс&raquo;, зал &laquo;Экстрополис&raquo;.</p>

<p><em>С уважением,<br />
<span style="line-height: 1.6em;">Институт Развития Интернета</span></em></p>




</td>
                </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

            <!-- content -->
            <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">

                    <table class="body-wrap" style="border-spacing: 0; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="text-align: right; border-right-width: 1px; border-right-color: #7d1b6f; border-right-style: solid; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0 10px 0 0;" align="right">
                        <a href="tel:74952858877" class="pink" style="text-decoration: none; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 10px; line-height: 1.6; color: #c21562; margin: 0; padding: 0;">+7 495 285-88-77</a>
                    </td>
                        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0 0 0 10px;">
                            <span class="dark-pink" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 10px; line-height: 1.6; color: #7d1b6f; margin: 0; padding: 0;">Институт Развития Интернета</span>
                        </td>
                    </tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="text-align: right; border-right-width: 1px; border-right-color: #7d1b6f; border-right-style: solid; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0 10px 0 0;" align="right">
                        <a href="http://xn--h1aax.xn--p1ai/about/" class="pink" style="text-decoration: none; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 10px; line-height: 1.6; color: #c21562; margin: 0; padding: 0;">ири.рф</a>

                    </td>
                        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0 0 0 10px;">
                            <span class="dark-pink" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 10px;
                            line-height: 1.6; color: #7d1b6f; margin: 0; padding: 0;">109028, Москва, Серебряническая наб., д. 29, БЦ Серебряный город, 7эт.</span>

                        </td>
                    </tr></table></td>
                </tr></table></div>
            <!-- /content -->

        </td>
        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
    </tr></table></body>
</html>