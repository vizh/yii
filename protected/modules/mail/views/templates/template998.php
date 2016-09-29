<?php

use api\models\ExternalUser;
use ruvents\components\QrCode;
use user\models\User;

/**
 * @var User $user
 */

$apiExtUser = ExternalUser::model()->byUserId($user->Id)->find();
?>

<table style="width: 100%;">
    <tr>
        <td>&nbsp;</td>
        <td width="700">
            <table cellpadding="0" cellspacing="0" border="0" width="700" align="left" style="border: 1px solid #efefef; font-family:Segoe UI,Tahoma,Arial,Helvetica, sans-serif; font-size:13px;">
                <tr>
                    <td height="140">
                        <a href="http://www.msdevcon.ru/certification">
                            <img width="700" src="http://runet-id.com/img/mail/2016/mdc16.jpg"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="10" cellspacing="10" border="0" width="100%">
                            <tr>
                                <td valign="middle">
                                    <h3 class="p1" style="font-size: 26px; margin: 0;">
                                        <span class="s1">Здравствуйте,
                                            <?=$user->getShortName()?>!
                                        </span>
                                    </h3>
                                </td>
                                <td valign="middle" align="center">
                                    <?=\CHtml::image(QrCode::getAbsoluteUrl($user, 110))?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="margin-top: 0;">До начала конференции <a href="http://www.msdevcon.ru/">DevCon
                                                                                                                      2016</a>
                                                              остается
                                                              всего несколько дней, и мы спешим напомнить вам о самом
                                                              главном.
                                    </p>


<p><strong>Даты конференции:</strong> 25-26 мая</p>

<p><strong>Место проведения: </strong>Природный курорт Клязьма, Московская область, поселок Поведники, ул. Еловая, д. 33.</p>

<p>&nbsp;</p>

<h3><strong>Трансфер</strong></h3>

<ul>
	<li>Добраться до конференции вы сможете на специальных бесплатных <strong>автобусах</strong>, которые будут отправляться <strong>25 мая</strong> <strong>с 8:00 </strong>от метро &laquo;Бабушкинская&raquo; или <strong>на электричке</strong> до железнодорожной станции &laquo;Мытищи&raquo; (от ж/д станции до пансионата «Клязьма» будет курсировать микроавтобус). Полное расписание автобусов и маршрутов опубликовано <a href="http://www.msdevcon.ru/howtoget">на сайте</a> конференции.</li>
	<li><a href="http://www.msdevcon.ru/howtoget">На сайте</a> также опубликованы маршруты проезда на <strong>личном транспорте</strong>. Мы рекомендуем вам воспользоваться бесплатными автобусами, поскольку количество мест на парковке строго ограничено.</li>
	<li>Открытие конференции и пленарный доклад начнутся <strong>в 10:00</strong>. Пожалуйста, спланируйте свою поездку так, чтобы успеть к началу пленарного доклада.</li>
</ul>

<h3>&nbsp;</h3>

<h3><strong>Схема расположения автобусов около метро &laquo;Бабушкинская&raquo;:</strong></h3>
<p style="text-align: center;">
                                        <img src="https://monosnap.com/file/MHM9fbb0hJjMz8FaeGRTeX3ras9adg.png"/>
                                    </p>

<p>&nbsp;</p>

<h3><strong>Регистрация на конференцию и заселение в отель</strong></h3>

<ul>
	<li>По приезду вам необходимо зарегистрироваться и <strong>получить бейдж</strong> участника. Следуйте навигации &ndash; регистрация участников разных категорий будет обозначена на указателях.</li>
	<li><strong>После получения бейджа</strong> при наличии достаточного времени до начала пленарного доклада вы сможете прогуляться по интерактивной выставке, получить новенький рюкзак, начать знакомиться с природой и участниками.</li>
	<li>Также приглашаем всех участников, интересующихся Интернетом Вещей, Большими Данными или же просто современными тенденциями и технологиями <strong>заглянуть на стенд Intel.</strong> Инженеры компании продемонстрируют на практике результаты использования Intel&reg; Parallel Studio, библиотеки Intel&reg; DAAL и других решений. Не забудьте, что посетив стенд Intel можно не только узнать много полезного и интересного, но и выиграть ноутбук на базе процессора Intel и другие ценные и симпатичные сувениры.</li>
	<li>Заселение в отель начнется с 13:30 25 мая. Для вашего максимально быстрого и комфортного заселения, пожалуйста, заполните анкету, которую вам раздадут в автобусе.&nbsp;</li>
</ul>

<p>&nbsp;</p>

<h3><strong>Расписание докладов </strong></h3>

<p>Чтобы спланировать посещение сессий, ознакомьтесь, пожалуйста, с расписанием докладов <a href="http://www.msdevcon.ru/schedule">на сайте</a> или в приложении конференции. Специально для вашего удобства мы создали приложение для платформ <a href="https://www.microsoft.com/ru-ru/store/apps/ms-tech-events/9nblgggxx0qs">Windows Phone</a>, <a href="https://play.google.com/store/apps/details?id=com.microsoft.techevents">Android</a> и <a href="https://itunes.apple.com/ru/app/ms-tech-events/id1108984752?l=en&amp;mt=8">iOS</a>. Ищите его по названию &laquo;MS Tech Events&raquo; в своем магазине приложений или просто скачайте по ссылкам выше.</p>

<p>&nbsp;</p>

<h3><strong>Анкета участника конференции</strong></h3>

<p>По этой индивидуальной ссылке вы можете заполнить анкету участника мероприятия. За заполнение анкет мы предусмотрели для вас гарантированные приятные сюрпризы!<br />
<strong>Ссылка на заполнение анкеты будет доступна 26 мая</strong> с 0:01 до 23:59 (мск).</p>
<div style="text-align: center; background: #ffffff; border: 2px dashed #FFFFFF; padding: 10px;">

                                        <p style="margin-top: 0">
                                            <a href="https://events.techdays.ru/Worksheet/Fill/<?=$apiExtUser
                                                ? $apiExtUser->ExternalId
                                                : ''?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Заполнить
                                                                                                                                                                                                                                                                                                                                                                                     анкету</a>
                                        </p>
                                    </div>



<h3><strong>Специальная скидка в официальном магазине Microsoft </strong></h3>

<p>Специально для участников DevCon 2016 мы рады предложить скидку 5% на весь ассортимент товаров в официальном онлайн-магазине microsoftstore.ru. Для получения скидки используйте промокод <strong>DEVCON2016</strong>. Срок действия акции &ndash; с 25 мая по 1 июня 2016 года.</p>

<p>&nbsp;</p>

<h3><strong>Что обязательно нужно взять с собой?</strong></h3>

<ul>
	<li><strong>Паспорт. </strong>Необходим для заселения в отель. Иначе есть шанс, что ночевать вы будете на природе в окружении комаров.</li>
	<li><strong>Средство против комаров</strong>. Мы боремся с ними, но персональное средство поможет улучшить степень комфортности вашего пребывания в этом чудесном природном курорте.</li>
	<li><strong>Теплую непромокаемую одежду и зонт. </strong>Не забудьте проверить прогноз погоды перед отъездом и захватить необходимые вещи.</li>
	<li><strong>Хорошее настроение</strong>. Без него никак нельзя!</li>
</ul>

<p>&nbsp;</p>

<p><strong>До встречи на DevCon 2016!</strong></p>

<p>&nbsp;</p>

<p>С уважением,<br />
Организаторы конференции DevCon 2016<br/>
______________________________________</p>
<p>+7 (926) 37-37-320</p>

<p><a href="mailto:v-devcon@microsoft.com">v-devcon@microsoft.com</a></p>

<p><a href="http://www.msdevcon.ru">www.msdevcon.ru</a></p>

<p>#msdevcon</p>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="80">
                        <img src="http://runet-id.com/img/event/devcon14/email-footer.gif"/>
                    </td>
                </tr>
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
