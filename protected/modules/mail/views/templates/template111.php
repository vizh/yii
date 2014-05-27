<?php
/**
 * @var \user\models\User $user
 */

$externalUser = \api\models\ExternalUser::model()->byUserId($user->Id)->find();
?>
<table align="left" border="0" cellpadding="0" cellspacing="0" style="color: rgb(34, 34, 34); line-height: normal; border: 1px solid rgb(239, 239, 239); font-family: Tahoma, Arial, Helvetica, sans-serif;" width="700">
    <tbody>
    <tr>
        <td height="140" style="font-family: arial, sans-serif; margin: 0;"><a href="http://www.msdevcon.ru/" style="color: rgb(17, 85, 204);" target="_blank"><img src="http://runet-id.com/img/mail/2014/20140526-devcon1.png" /></a></td>
    </tr>
    <tr>
        <td style="font-family: arial, sans-serif; margin: 0;">
            <table border="0" cellpadding="10" cellspacing="10" width="100%">
                <tbody>
                <tr>
                    <td style="margin: 0;">
                        <p><strong>Здравствуйте, <?=$user->getShortName();?>!</strong><br/><span style="color:#cccccc;font-size:10px"><?=$user->RunetId;?></span></p>

                       <p>До начала конференции <a href="http://www.msdevcon.ru/">DevCon 2014</a> остается всего несколько дней, и мы спешим сообщить вам о самом главном.</p>
                                       
<p><strong>Даты конференции:</strong> 28-29 мая<br/> 
<strong>Место проведения:</strong> Природный курорт <a href="http://yahonty.ru/ob-otele/kontakty/#hotel">Яхонты</a>, Московская область, Ногинский район, 1 км южнее д.Жилино</p>

<p style="padding-top:15px;"><strong>Трансфер</strong></p>
<ul>
<li style="padding-bottom:10px;">Добраться до конференции вы сможете на специальных бесплатных <strong>автобусах</strong>, которые будут отправляться с <strong>7:00</strong> от метро «Партизанская» или <strong>на электричке до г.Ногинск</strong> с Курского вокзала (от ж/д станции Ногинск до отеля Яхонты будет курсировать микроавтобус). Полное расписание автобусов и маршрутов опубликовано <a href="http://www.msdevcon.ru/place">на сайте</a> конференции.</li>

<li style="padding-bottom:10px;"><a href="http://www.msdevcon.ru/place">На сайте</a> конференции также опубликованы маршруты проезда на <strong>личном транспорте</strong>. Всем участникам будет предоставлена бесплатная парковка.</li>

<li>Открытие конференции и пленарный доклад начнутся в <strong>11:00</strong>. Пожалуйста, спланируйте свою поездку так, чтобы успеть к началу пленарного доклада. </li>
</ul>

<p style="padding-top:15px;"><strong>Схема расположения автобусов около метро «Партизанская»:</strong></p>
<p><img src="http://runet-id.com/img/mail/2014/20140526-mapdevcon2.png"/></p>

<p style="padding-top:15px;"><strong>Регистрация на конференцию</strong></p>
<ul>
<li style="padding-bottom:10px;">По приезду вам необходимо зарегистрироваться и получить <strong>бейдж</strong> участника. <strong>До 13:00 28 мая</strong> стойка регистрации будет находиться в шатре Гостевого дома Microsoft. Если вы приедете позже – бейдж нужно получать в фойе на 1 этаже Конгресс-Холла. </li>

<li><strong>После получения бейджа</strong> при наличии достаточного времени до начала пленарного доклада вы сможете прогуляться по Гостевому дому Microsoft, угоститься там бодрящим кофе, получить новенький рюкзак с полезными материалами на стойке «Информация» в Конгресс-Холле, заселиться в отель и начать знакомиться с природой и участниками.</li>
</ul>

<p style="padding-top:15px;"><strong>Расписание докладов</strong></p>
<p>Чтобы спланировать посещение сессий, ознакомьтесь, пожалуйста, с расписанием докладов <a href="http://www.msdevcon.ru/schedule">на сайте</a> или в <a href="http://www.msdevcon.ru/apps">официальном приложении «DevCon 2014»</a>, разработанном специально для вашего удобства для всех популярных платформ.</p>


<p style="padding-top:15px;"><strong>Анкета участника конференции и оценка докладов</strong></p>
<p>По этой индивидуальной ссылке вы можете оценить доклады и заполнить анкету участника мероприятия. Обратите внимание, что заполнение анкеты участника доступно с утра 29 мая. За заполнение анкет мы предусмотрели для вас гарантированные призы и приятные сюрпризы!</p>
<?if ($externalUser !== null && $externalUser->ShortExternalId !== null):?>
<p><a href="http://www.msdevcon.ru/vote/<?=$externalUser->ShortExternalId;?>" style="display: block; text-decoration: none; background: #5b9bd5; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">Заполнить анкету</a></p>
<?endif;?>


<p><strong>Что обязательно нужно взять с собой?</strong></p>
<ul>
<li style="padding-bottom:10px;"><strong>Паспорт</strong>. Необходим для заселения в отель. Иначе есть шанс, что ночевать вы будете на природе в окружении комаров =)</li>
<li style="padding-bottom:10px;"><strong>Средство против комаров</strong>. Мы боремся с ними, но персональное средство поможет улучшить степень комфортности вашего пребывания в этом чудесном природном курорте.</li>	
<li style="padding-bottom:10px;"><strong>Теплую непромокаемую одежду и зонт</strong>. Не забудьте проверить прогноз погоды перед отъездом и захватить необходимые вещи.</li>
<li><strong>Хорошее настроение</strong>. Без него никак нельзя!</li>
</ul>

<p style="padding-top:15px;"><strong>Полезные приложения</strong></p>
<p>Обратите внимание на очень полезные приложения, которые могут вам пригодиться в эти 2 славных дня:<br/>
<a href="http://www.windowsphone.com/ru-ru/store/app/%D0%B1%D1%83%D0%B4%D0%B8%D1%81%D1%82/c7848436-eef3-47be-a004-61adffc92576">Будист</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/flashlight/b33db425-39fe-44ed-be87-ad77a772bc96">Flashlight</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/antimosquito/64c34065-d04c-40b4-a3e5-bfcc6846a34c">AntiMosquito</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/%D0%BF%D0%B5%D1%80%D0%B2%D0%B0%D1%8F-%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D1%8C/f2632471-c1e9-447f-a20c-16298694f80d">Первая помощь</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/outdoor-navigation/83f78cdd-fb29-e011-854c-00237de2db9e">Outdoor Navigation</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/outingorganizer/ed896aac-0d67-4de4-ba50-d525d18a9183">OutingOrganizer</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/2gis/4c2d3b4e-c1f1-439b-bf16-f8b0d829fe87">2GIS</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/trip-planner/e04ef0bd-b7fe-4a45-a8d6-4e7201c1fdc6">Trip Planner</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/oldcompass/d3f14bc0-57eb-4d27-95ea-acfd46e28782">OldCompass</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/tripmeter/efd833eb-c935-4968-861c-c52990a4cb7f">TripMeter</a>, <a href="http://www.windowsphone.com/ru-ru/store/app/office-lens/5681f21c-f257-4d62-83f5-5341788a5077">Office Lens</a></p>

<p>До встречи на DevCon 2014! Мы уже заждались вас =)</p>

<p>С уважением,<br/>
организаторы конференции DevCon 2014<br/>
____________________________________<br/><br/>
+7 (915) 195-06-70<br/>
ms@devcon2014.ru<br/>
www.msdevcon.ru<br/>
#msdevcon 
</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="80" style="font-family: arial, sans-serif; margin: 0;"><img src="http://runet-id.com/img/event/devcon14/email-footer.gif" /></td>
    </tr>
    </tbody>
</table>