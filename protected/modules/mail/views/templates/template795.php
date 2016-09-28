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
                <h2 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 28px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;"><a style="text-decoration: none;" href="<?=$user->getUrl()?>"><?=$user->getShortName()?></a>, здравствуйте!</h2>


                <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                    От имени Института Развития Интернета –
                    благодарим за Ваш профессиональный вклад в работу над Программой
                    <a href="http://ie.iri.center/"> Форума "Интернет Экономика"</a> и участие в нем в качестве докладчика.
                </p>

                <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                    По итогам работы Форума – предлагаем Вам рассмотреть возможность делегироваться в Экспертный Совет Института Развития Интернета (ЭС ИРИ).
                </p>



                <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                    Для этого необходимо перейти по Вашей персональной сслыке
                </p>

                <?
                 $salt = '71064386e1731ff1ceb2b4667ce67b8c';
                    $hash = md5($user->RunetId . $salt . 'expert');
               ?>

                <div style=" text-align: center; margin-top: 20px;">
                    <p style="margin-top: 10px; text-align: center;">
                        <a href="http://iri.runet-id.com/becomeexpert/?runetid=<?=$user->RunetId?>&hash=<?=$hash?>"
                           style="font-size: 100%;
                           color: #FFF; text-decoration: none; font-weight:
                           bold; text-align: center; cursor: pointer;
                           display: block; border-radius: 5px;
                           text-transform: uppercase; background-color: #c21562; margin: 0 auto; padding: 0;
                           border-color: #c21562; border-style: solid; border-width: 5px; width: 50%;" target="_blank">
                            ПОДТВЕРДИТЬ УЧАСТИЕ</a></p>
                </div>

                <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                    После чего Ваша заявка поступит на обработку в ИРИ.
                </p>
            </td>
            </tr>
            </table>
        </div>
    </td>
</tr>
    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" bgcolor="#dcdcdc" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

            <!-- content -->
            <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">








                    <h3 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        <b>Справка</b>
                    </h3>


                    <p style="font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        В январе 2016 года запланированы модификация и дополнение состава ЭС ИРИ, инициированные Советом ИРИ по итогам работы в 2015 году. Предполагается, что обновленный состав Экспертного Совета ИРИ будет опубликован до конца января.
                    </p>


                    <p style="font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        Поводом для изменения состава ЭС ИРИ стали итоги работы над Программой развития Интернета и дорожными картами, а также итоги проведения круглых столов Форума “Интернет Экономика 2015” (21-22 декабря 2015 года), в результате которых Экспертное сообщество ИРИ значительно расширилось и модифицировалось: появились новые отраслевые эксперты и эксперты из смежных отраслей.
                    </p>


                    <p style="font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        В наступающем 2016 году Экспертному Совету (<a href="http://iri.center/experts/">ЭС ИРИ</a>) предстоит решить ряд серьезных  задач для реализации планов и начинаний, фундамент которых заложен в 2015. <b>Уже в январе 2016 года будут разработаны и опубликованы обновленные принципы формирования Экспертного совета ИРИ</b>, которые позволят повысить эффективность его работы, привлечь активных отраслевых экспертов и экспертов из смежных отраслей, готовых сделать реальный вклад в оценку инициатив ИРИ и болеющих за судьбу отрасли.
                    </p>


                    <p style="font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        На сегодняшний день в состав ЭС ИРИ, сформированного в период с апреля по октябрь 2015 года с использованием платформы <a href="http://runet-id.com/">www.runet-ID.com</a>, входят около 900 ведущих деятелей российского сегмента сети Интернет, распределенных по 25 экосистемам Рунета (т.н. “Кластеры” или “Экосистемы Рунета”).
                    </p>


                    <p style="font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        Напомним, что нынешний ЭС ИРИ был сформирован в несколько этапов из большого числа отраслевых экспертов Рунета. Первоначальный список кандидатов составлен на базе рекомендаций членов Совета ИРИ (включая представителей ФРИИ, РАЭК, МКС и РОЦИТ). Важной особенностью процесса выдвижения кандидатов в ЭС ИРИ стал экспертно-вирусный характер отбора претендентов: каждый приглашенный кандидат мог выдвинуть еще нескольких кандидатов в эксперты, за которых на втором этапе формирования ЭС ИРИ осуществлялось онлайн-голосование коллег в каждой Экосистеме Рунета.
                    </p>


                    <p style="font-style: italic; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
                        Мы надеемся, что учет опыта 2015 года и, в первую очередь, итоги вовлеченности экспертов в программу Форума “Интернет Экономика 2015”, помогут трансформировать ЭС ИРИ уже в начале 2016 года и превратить его в действительно мощный и эффективный инструмент отраслевой и межотраслевой экспертизы инициатив Института.
                    </p>


                </td>
                </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" bgcolor="#c21562" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

            <!-- content -->
            <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">

                    <h1 style="text-align: center; color: #fff">С наступающим Новым 2016 годом! Успешной экспертной работы в новом году! </h1>

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

