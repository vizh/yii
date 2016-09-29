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
                        <a href="http://www.msdevcon.ru">
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

                                    <p>Большое спасибо, что стали участником конференции <a href="http://www.msdevcon.ru/">DevCon 201</a>6! Нам очень важно узнать ваше мнение о мероприятии.</p>

                                    <p>По этим индивидуальным ссылкам вы можете оценить доклады и заполнить анкету участника мероприятия. Обратите внимание, что <strong>заполнение анкеты участника доступно с 10:00 до 23:59 25 мая, а оценка докладов с 10:00 25 мая до 23:59 26 мая.</strong> Мы предусмотрели для вас приятные сюрпризы, которые гарантированно получит каждый заполнивший анкету!</p>

                                    <div style="text-align: center; background: #ffffff; border: 2px dashed #FFFFFF; padding: 10px;">

                                        <p style="margin-top: 0">
                                            <a href="https://events.techdays.ru/Worksheet/Fill/<?=$apiExtUser
                                                ? $apiExtUser->ExternalId
                                                : ''?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Заполнить анкету</a>
                                            <a href="https://events.techdays.ru/Voting/Fill/<?=$apiExtUser
                                                ? $apiExtUser->ExternalId
                                                : ''?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Оценить доклады</a>
                                        </p>
                                    </div>

                                    <p>Делитесь своими впечатлениями о конференции с хэштегом <a href="https://twitter.com/hashtag/msdevcon?f=realtime&amp;src=hash">#msdevcon</a></p>

                                    <p>Спасибо, что вы с нами!</p>

                                    <p>&nbsp;</p>

                                    <p>С уважением,<br />
                                       Команда организаторов конференции DevCon 2016</p>

                                    <p>---------------------------------</p>

                                    <p><a href="http://www.msdevcon.ru">www.msdevcon.ru</a></p>

                                    <p><a href="https://twitter.com/hashtag/msdevcon?f=realtime&amp;src=hash">#msdevcon </a></p>
                                </td>
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
