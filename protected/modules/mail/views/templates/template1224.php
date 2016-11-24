<?php
$regLink = "http://2016.goldensite.ru/personal/expert/?RUNETID={$user->RunetId}&KEY=".substr(md5("{$user->RunetId}kZhtzhEQnD7y75KriNndzTh8Y"), 0, 16)
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Золотой Сайт 2016 – старт голосования экспертов!</title>
</head>
<body bgcolor="#FFFFFF" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; background: #FFFFFF; margin: 0; padding: 0;">
<style type="text/css">
    @media (max-width: 400px) {
        .chunk {
            width: 100% !important;
        }
    }
</style>

<!-- body -->
<table class="body-wrap" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;">
    <tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
        <td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" bgcolor="#FFFFFF" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px;">
            <!-- content -->
            <div class="content" style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <table style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; vertical-align: top; width: 100%; margin: 0; padding: 0;">
                    <tr style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
                        <td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; vertical-align: top; margin: 0; padding: 0;" valign="top">
                            <h2 style="text-align: center;">Здравствуйте, <?=$user->getShortName();?>!</h2>
                            <p>Итак, на Золотом Сайте стартует этап голосования.</p>
                            <ol>
                                <li>На сайте Конкурса <a href="http://2016.goldensite.ru/nominations/">уже опубликованы все работы во всех номинациях</a>.</li>
                                <li>В пятницу, 11 ноября, мы уже писали вам письмо с длинной инструкцией-регламентом по оценке конкурсных работ.  Перед стартом голосования рекомендуем еще раз его внимательно прочитать.</li>
                                <li>Чтобы начать оценку работ, вам нужно:
                                    <ul>
                                        <li>Перейти к <a href="<?=$regLink?>">персональному списку обязательных работ для оценки</a>.</li>
                                        <li>Открыть страницы работ с подробным описанием и начать их оценивать.</li>
                                        <li>Если вы авторизовались, то на странице каждой работы в нижней части должен появиться желтый блок «Оценка эксперта жюри». Если блок не появился, <a href="mailto:2016@goldensite.ru">напишите нам</a>.</li>
                                    </ul>
                                </li>
                                <li>Если вы считаете работу достойной общего гран-при или приза за «неожиданное решение», отметьте ее соответствующим чекбоксом в блоке голосования.</li>
                                <li>Вы можете голосовать не только за работы из персонального списка, но и за любые другие работы на сайте конкурса.</li>
                            </ol>
                            <p>Надо помнить, что голосовать за свои работы запрещено, а все ваши оценки будут опубликованы в открытом режиме после подведения итогов и доступны любому желающему.</p>
                            <p>Этап голосования будет идти до 2 декабря, а Церемония Награждения пройдет 14 декабря в Москве.</p>
                            <p>Спасибо, что помогаете нам и Председателю Жюри Виталию Быкову с судейством!</p>
                            <p>С уважением,<br><a href="mailto:2016@goldensite.ru">Оргкомитет Золотого Сайта</a></p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="font-family: Verdana, Geneva, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
    </tr>
</table>
</body>
</html>
