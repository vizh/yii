<?php
$discount = new \pay\models\Coupon();
$discount->EventId  = 2386;
$discount->Code = $discount->generateCode();
$discount->EndTime  = null;
$discount->Discount = 100;
$discount->save();

$product = \pay\models\Product::model()->findByPk(4053);
$discount->addProductLinks([$product]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Специальное предложение для членов Экспертного Совета ИРИ</title>
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
                <img src="http://getlogo.org/img/i-com/1137/x50/" style="height: auto; float: right; width: auto; max-width: 320px; margin: 25px auto 0; padding: 0;">

<p>14-15 марта во ФРИИ Сити Холле пройдет конференция <a href="http://www.i-comference.ru">i-CоM 2016</a>, посвященная <strong>социальным и мобильным коммуникациям и автоматизации маркетинговых процессов</strong>.</p>
<p><strong><?=$user->getShortName()?></strong>,<br/>Вы – эксперт Института Развития Интернета – <a href="http://ири.рф/experts/">ЭС ИРИ 2016 года</a>.<br/>И Вам предоставляется право бесплатного участия в конференции i-CоM 2016.</p>
<p>Если вы планируете принять участие в конференции, активируйте Ваш персональный промо-код на 100% скидку: <span style="background: #F9F1C7; display: inline-block; padding: 2px 3px; font-weight: bold;"><?=$discount->Code?></span></p>
<p><strong>ВНИМАНИЮ<br/></strong><strong>обладателей пластиковых карт "Эксперт ИРИ"</strong>
</p>
<blockquote>
	<p>Пластиковые карты “Эксперт ИРИ” выдавались всем <a href="http://ири.рф/news/10780/">участникам встречи ЭС ИРИ 2016</a> (4 марта 2016 года, конференц-центр Яндекса).</p>
	<p>Если Вы уже являетесь обладателем пластиковой карты "Эксперт ИРИ" – предъявите её на стойке регистрации i-CoM 2016 (14 или 15 марта) – и Вы получите право бесплатного безлимитного посещения конференции.</p>
	<p>Если у Вас еще нет такой карты “Эксперт ИРИ”, и Вы хотели бы ее получить, Вы можете сообщить об этом на стойке регистрации i-CoM 2016 (14 или 15 марта), обратившись к представителю RUNET–ID и ИРИ.</p>
</blockquote>
<p>До встречи на Форуме!</p>


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