<?$regLink = "http://2014.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);?>

<table align="center" border="0" cellpadding="0" cellspacing="0" style="color: rgb(34, 34, 34); line-height: normal; border: 1px solid rgb(239, 239, 239); font-family: Tahoma, Arial, Helvetica, sans-serif;" width="600">
    <tbody>
    <tr>
        <td height="140" style="font-family: arial, sans-serif; margin: 0px;"><img src="http://runet-id.com/img/mail/2014/20140506-spic14.jpg" /></td>
    </tr>
    <tr>
        <td style="font-family: arial, sans-serif; margin: 0px;">
            <table border="0" cellpadding="10" cellspacing="10" width="100%">
                <tbody>
                <tr>
                    <td style="margin: 0px;">
                        <h3><?=$user->getShortName();?>, здравствуйте!</h3>
                        <p>Вы - зарегистрировались на сайте Санкт-Петербургской Интернет Конференции (<a href="http://sp-ic.ru">СПИК 2014</a>).&nbsp;</p>
                        <p>Ваш статус <strong>&laquo;Виртуальный участник&raquo;</strong>&nbsp;дает Вам право посещать <a href="http://2014.sp-ic.ru/exhibition/">выставку</a> все дни ее работы: 27-28 мая &nbsp;2014 года. Посетителей выставки ждут консультации специалистов, живое общение с компаниями-лидерами Рунета в Северо-Западном федеральном округе, промо-продукция и развлекательные мероприятия с приятными бонусами.&nbsp;</p>
                        <p><strong>ВНИМАНИЕ!</strong><br />
                        Если Вы планируете принять участие в <a href="http://2014.sp-ic.ru/program/">профессиональной конференционной программе</a> СПИК в качестве слушателя - важно помнить, что такое участие - платное. Оплатить участие можно в личном кабинете.</p>
                        <p align="center" style="text-align: center"><a href="<?=$regLink?>" style="display: inline-block; text-decoration: none; background: #D42E00; color: #FFFFFF; font-size: 20px; border-radius: 3px; margin: 0 auto; padding: 16px; line-height: 14px; text-align: center; width: 300px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
                        <p>При оплате участия в Программе до 12 мая включительно &ndash; действует льготная стоимость регистрации: 3000 рублей включая налоги (за все дни / все блок-конференции / посещение бизнес-зоны). С 12 мая цена участия вырастет до 3 500 рублей.</p>
                        <p><br />
                            <span style="font-family: Tahoma, Helvetica, sans-serif;"><em>​С уважением,</em></span><br />
                            <span style="font-family: Tahoma, Helvetica, sans-serif;"><em>оргкомитет СПИК 2014</em></span></p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>