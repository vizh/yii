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
                                            <?= $user->getShortName(); ?>!
                                        </span>
                                    </h3>
                                </td>
                                <td valign="middle" align="center">
                                    <?= \CHtml::image(QrCode::getAbsoluteUrl($user, 110)); ?>
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

                                    <p><strong>Место проведения: </strong>Природный курорт Клязьма, Московская область,
                                                                          поселок Поведники, ул. Еловая, д. 33.
                                    </p>

                                    <p><strong>Трансфер</strong></p>

                                    <ul>
                                        <li>Добраться до конференции вы сможете на специальных бесплатных <strong>автобусах</strong>,
                                            которые будут отправляться <strong>25 мая</strong> <strong>с 8:00 </strong>от
                                            метро &laquo;Бабушкинская&raquo; или <strong>на электричке</strong> до
                                            железнодорожной станции &laquo;Мытищи&raquo; (от ж/д станции до отеля Яхонты
                                            будет курсировать микроавтобус). Полное расписание автобусов и маршрутов
                                            опубликовано <a href="http://www.msdevcon.ru/howtoget">на сайте</a>
                                            конференции.
                                        </li>
                                        <li><a href="http://www.msdevcon.ru/howtoget">На сайте</a> также опубликованы
                                                                                                   маршруты проезда на
                                            <strong>личном транспорте</strong>. Мы рекомендуем вам воспользоваться
                                                                                                   бесплатными
                                                                                                   автобусами, поскольку
                                                                                                   количество мест на
                                                                                                   парковке строго
                                                                                                   ограничено.
                                        </li>
                                        <li>Открытие конференции и пленарный доклад начнутся <strong>в 10:00</strong>.
                                            Пожалуйста, спланируйте свою поездку так, чтобы успеть к началу пленарного
                                            доклада.
                                        </li>
                                    </ul>

                                    <p><strong>Схема расположения автобусов около
                                               метро &laquo;Бабушкинская&raquo;:</strong></p>

                                    <p style="text-align: center;">
                                        <img src="https://monosnap.com/file/MHM9fbb0hJjMz8FaeGRTeX3ras9adg.png"/>
                                    </p>

                                    <p>&nbsp;</p>

                                    <p><strong>Регистрация на конференцию и заселение в отель</strong></p>

                                    <ul>
                                        <li>По приезду вам необходимо зарегистрироваться и <strong>получить
                                                                                                   бейдж</strong>
                                            участника. Следуйте навигации &ndash; регистрация участников разных
                                            категорий будет обозначена на указателях.
                                        </li>
                                        <li><strong>После получения бейджа</strong> при наличии достаточного времени до
                                                                                    начала пленарного доклада вы сможете
                                                                                    прогуляться по интерактивной
                                                                                    выставке, получить новенький рюкзак,
                                                                                    начать знакомиться с природой и
                                                                                    участниками.
                                        </li>
                                        <li>Заселение в отель для участников с билетами категории DevCon и DevCon Lite
                                            начнется с 13:30 25 мая. Для вашего максимально быстрого и комфортного
                                            заселения, пожалуйста, заполните анкету, которую вам раздадут в автобусе.
                                            &nbsp;</li>
                                    </ul>

                                    <p><strong>Расписание докладов </strong><br/>
                                        Чтобы спланировать посещение сессий, ознакомьтесь, пожалуйста, с расписанием
                                        докладов <a href="http://www.msdevcon.ru/schedule">на сайте</a> или в приложении
                                        конференции. Специально для вашего удобства мы создали приложение для платформ
                                        Windows Phone, Android и iOS. Ищите его по названию &laquo;MS Tech Events&raquo;
                                        в своем магазине приложений.
                                    </p>

                                    <p><strong>Анкета участника конференции и оценка докладов</strong><br/>
                                        По этой индивидуальной ссылке вы можете оценить доклады и заполнить анкету
                                        участника мероприятия. За заполнение анкет мы предусмотрели для вас
                                        гарантированные приятные сюрпризы!
                                    </p>

                                    <div style="text-align: center; background: #ffffff; border: 2px dashed #FFFFFF; padding: 10px;">

                                        <p style="margin-top: 0">
                                            <a href="https://events.techdays.ru/Worksheet/Fill/<?= $apiExtUser
                                                ? $apiExtUser->ExternalId
                                                : ''; ?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Заполнить
                                                                                                                                                                                                                                                                                                                                                                                     анкету</a>
                                        </p>
                                    </div>

                                    <p><strong>Специальная скидка в официальном магазине Microsoft </strong><br/>
                                        Специально для участников DevCon 2016 мы рады предложить скидку 5% на весь
                                        ассортимент товаров в официальном онлайн-магазине microsoftstore.ru. Для
                                        получения скидки используйте промокод <strong>DEVCON2016</strong>. Срок действия
                                        акции &ndash; с 25 мая по 1 июня 2016 года.
                                    </p>

                                    <p>&nbsp;</p>

                                    <p><strong>Что обязательно нужно взять с собой?</strong></p>

                                    <ul>
                                        <li><strong>Паспорт. </strong>Необходим для заселения в отель. Иначе есть шанс,
                                                                      что ночевать вы будете на природе в окружении
                                                                      комаров J
                                        </li>
                                        <li><strong>Средство против комаров</strong>. Мы боремся с ними, но персональное
                                                                                    средство поможет улучшить степень
                                                                                    комфортности вашего пребывания в
                                                                                    этом чудесном природном курорте.
                                        </li>
                                        <li><strong>Теплую непромокаемую одежду и зонт. </strong>Не забудьте проверить
                                                                                                 прогноз погоды перед
                                                                                                 отъездом и захватить
                                                                                                 необходимые вещи.
                                        </li>
                                        <li><strong>Хорошее настроение</strong>. Без него никак нельзя!</li>
                                    </ul>

                                    <p>До встречи на DevCon 2016!</p>
                                    <p>&nbsp;</p>
                                    <p>С уважением,<br/>
                                       организаторы конференции DevCon 2016
                                    </p>

                                    <p><a href="http://www.msdevcon.ru">www.msdevcon.ru</a></p>

                                    <p><a href="https://twitter.com/search?q=%23msdevcon&amp;src=typd">#msdevcon</a></p>

                                    <p><a href="mailto:v-devcon@microsoft.com">v-devcon@microsoft.com</a></p>

                                    <p>+7 (926) 37-37-320</p>

                                    </p></td>
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
