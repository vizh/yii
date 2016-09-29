<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

use event\models\UserData;
use user\models\User;
use event\models\Event;
use event\models\Participant;
use ruvents\components\QrCode;

$data = UserData::model()
    ->byEventId($event->Id)
    ->byUserId($user->Id)
    ->byDeleted(false)
    ->orderBy(['"t"."CreationTime"'])
    ->find();

$customNumber = null;
if ($data) {
    $customNumber = $data->getManager()->Custom_Number;
}

?>
<style>

    html, body {
        padding: 0;
        margin: 0;
        font-family: arial;
    }

    header{
        border-bottom: 5px solid black;
        padding-top: 78px;
    }

    .main{
        margin: 0 50px;
        width: 100%;
    }

    .border-right{
        border-right: 2px solid black;
        padding: 5px 58px 5px 0;
    }
    h3{
        text-transform: uppercase;
    }

    .parking {
        width: 20px;
        height: 30px;
        margin-right: 20px;
    }


    .td-padding{
        padding-left: 15px;
    }

    li{
        margin-bottom: 20px;
    }

    .logo{
        padding-right: 20px;
    }

    .logo > img {
        width: 150px;

    }

    .icons{
        margin: 20px 0;
        width: 80%;
    }
</style>

<header>
    <div class="main">
        <table style="width: 100%">
            <tr>
                <td class="logo">
                    <img src="/img/ticket/isrussia16/logo-red.jpg">
                </td>
                <td>

                    <?if(\Yii::app()->language == 'en'):?>
                        INTERNATIONAL EXHIBITION<br>
                        1-3 November, 2016<br>
                        Moscow, Expocentre, pavilions "Forum", №1<br>
                    <?php else:?>
                        МЕЖДУНАРОДНАЯ ВЫСТАВКА<br>
                        1-3 Ноября 2016<br>
                        Москва, Экспоцентр, павильоны «Форум», №1<br>
                    <?endif?>
                </td>
                <td style="text-align: center; width: 100px;">
                    <?=$user->RunetId?>
                        <?=\CHtml::image(QrCode::getAbsoluteUrl($user, 100), '')?>
                </td>
            </tr>
        </table>

        <?if(\Yii::app()->language == 'en'):?>
            <img class="icons" src="/img/ticket/isrussia16/icons-en-red.jpg">
        <?php else:?>
            <img class="icons" src="/img/ticket/isrussia16/icons-ru-red.jpg">
        <?endif?>
    </div>
</header>
<section>
    <div class="main">
        <?if(\Yii::app()->language == 'en'):?>
            <p>Thank you for registering the International Exhibition Integrated Systems Russia.</p>
            <h3>TIME AND VENUE OF THE EXHIBITION:</h3>
            <table>
                <tr>
                    <td class="border-right">
                        November 1 11:00 – 18:00<br>
                        November 2 10:00 – 18:00<br>
                        November 3 10:00 – 17:00<br>
                    </td>
                    <td class="td-padding">
                        Moscow, Expocentre, pavilion “Forum”, 1<br>
                        Krasnopresnenskaya embankment, 14<br>
                        Metro station “Exhibition”<br>
                    </td>
                </tr>
            </table>
            <h3>FOR ENTERING THE EXHIBITION HALLS YOU WILL NEED TO:</h3>
            <ol>
                <li>Give your printed e-mail invitation to the show staff member at the Internet Registration desk.</li>
                <li>Take your personal badge.</li>
                <li>Pass the wicket-gate with your badge bar-code. When the green lamp switches on you may pass.</li>
            </ol>

            <table>
                <tr>
                    <td>
                        <div class="parking">
                            <img src="/img/ticket/isrussia16/parking.jpg">
                        </div>
                    </td>
                    <td>
                        <p>If you experience problems with parking at Krasnopresnenskaya embankment,<br>
                            you can use a paid underground parking at AFIMALL shopping centre</p>
                    </td>
                </tr>
            </table>

            <h3>
                THE TICKET IS VALID FOR VISITING EXHIBITIONS<br>
                INTEGRATED SYSTEMS RUSSIA, HI-TECH BUILDING,
                PTA - expo 2016, Russian Interactive Week (RIW.Moscow)
            </h3>

        <?php else :?>
            <p>БЛАГОДАРИМ Вас за регистрацию на международную выставку Integrated Systems Russia.</p>
            <h3>МЕСТО И ВРЕМЯ РАБОТЫ ВЫСТАВКИ</h3>
            <table>
                <tr>
                    <td class="border-right">
                        1 ноября с 11:00 до 18:00<br>
                        2 ноября с 10:00 до 18:00<br>
                        3 ноября с 10:00 до 17:00<br>
                    </td>
                    <td class="td-padding">
                        Москва, ЦВК "Экспоцентр", павильон 1<br>
                        Краснопресненская набережная, 14<br>
                        Станция метро "Выставочная"
                    </td>
                </tr>
            </table>
            <h3>Для входа в выставочный зал необходимо:</h3>
            <ol>
                <li>На стойке интернет-регистрации предьявить оператору распечатанное электронное приглашение для сканирования штрих-кода.</li>
                <li>Получить Ваш персональный бейдж посетителя выставки.</li>
            </ol>

            <table>
                <tr>
                    <td>
                        <div class="parking">
                            <img src="/img/ticket/isrussia16/parking.jpg">

                        </div></td>
                    <td>
                        <p>В случае возникновения затруднений с парковкой на Краснопресненской набережной<br>
                            предлагаем Вам воспользоваться услугами платной подземной парковки<br> ТЦ "АФИМОЛ"</p>
                    </td>
                </tr>
            </table>

            <h3>
                БИЛЕТ ДЕЙСТВИТЕЛЕН ДЛЯ ПОСЕЩЕНИЯ ВЫСТАВОК<br>
                INTEGRATED SYSTEMS RUSSIA, HI-TECH BUILDING, «Передовые технологии автоматизации. ПТА», Russian Interactive Week (RIW.Moscow).
            </h3>

        <?endif?>
    </div>
</section>