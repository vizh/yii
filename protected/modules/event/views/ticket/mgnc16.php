<?php

use user\models\User;
use event\models\Event;
use event\models\Participant;
use ruvents\components\QrCode;

/**
 * @var User                      $user
 * @var Event                     $event
 * @var Participant|Participant[] $participant
 */

if (is_array($participant)) {
    $participant = $participant[0];
}
?>

<style>
    .root-col-4, table {
        font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #2F363E;
    }

    .pull-left {
        float: left;
    }

    .pull-right {
        float: right;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-white {
        color: white;
    }

    .valign-middle {
        vertical-align: middle;
    }

    .text-black {
        color: black;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .rotate {
        rotate: 90;
    }

    .hidden {
        display: none;
    }

    .root-col-4 {
        position: absolute;
        width: 89mm;
        height: 200mm;
    }

    .root-cut {
        position: absolute;
        left: 0;
        width: 100%;
        height: 10mm;
        /*background: url('/img/ticket/pdf/base/cutting.png') center center no-repeat;*/
    }

    .root-cut-line {
        height: 5.3mm;
        border-bottom: .3mm dashed #bbbbbb;
    }

    .root-round-top {
        border-radius: 4mm 4mm 0 0;
    }

    .root-round-bottom {
        border-radius: 0 0 4mm 4mm;
    }

    .bg-orange {
        background: #ff4002;
    }

    .text-orange {
        color: #ff4002;
    }

    img {
        image-resolution: 120dpi;
    }
</style>

<div class="root-col-4 rotate" style="top: 5mm;">
    <div class="text-center text-white root-round-top bg-orange text-uppercase" style="padding: 3mm 0; font-size: 5mm;">
        Электронный билет
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC; padding: 3mm 5mm;">
        <div class="text-uppercase" style="color: #ddd; font-size: 8mm; font-family: 'PT Sans', sans-serif; visibility: hidden;">Дубликат
        </div>
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="text-uppercase" style="font-size: 6mm">Конференция</div>
                    <div style="font-size: 6mm">с участием</div>
                </td>
                <td class="text-right">
                    <img src="/img/event/mgnc16/logo.png" style="width: 20mm;" alt="">
                </td>
            </tr>
        </table>
        <img src="/img/event/mgnc16/title.png" style="width: 100%" alt="">
        <br><br>
        <div>
            <em style="font-size: 5mm"><strong>5 сентября</strong> в 11:00</em>
        </div>
    </div>
    <div style="background: #E7E7E7; padding: 2mm 5mm;">
        г. Москва <br> ул. Иркутская 11 корп. 1
    </div>
    <div style="background: #2F363E; padding: 5mm;" class="text-white">
        <div style="font-size: 8mm;">
            <?= $user->LastName; ?><br>
            <?= $user->FirstName; ?>
        </div>
        <div class="text-uppercase" style="margin-top: 15mm;">
            <?= $participant->Role->Title ?>
        </div>
    </div>
    <div class="text-center" style="background: #E7E7E7; padding: 2mm 5mm; font-size: 3.6mm;">
        Ваш штрих-код для входа на конференцию
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC; padding: 2mm 5mm;">
        <div style="padding: 5mm 0;" class="text-center">
            <barcode code="<?= $user->RunetId; ?>" type="C128A" size="1" height="1"/>
            <br>
            <div style="font-size: 3mm;"><?= $user->RunetId; ?></div>
        </div>
        <div class="text-center text-orange">
            При входе в здание с Вашего билета <br> будет считываться штрих-код
        </div>
    </div>
    <div class="bg-orange root-round-bottom" style="height: 4mm;"></div>
</div>
<div class="root-cut" style="top: 94mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4 rotate" style="top: 104mm;">
    <div class="text-center text-white root-round-top bg-orange text-uppercase" style="padding: 7mm 15mm; font-size: 5mm;">
        Вход в здание церкви на конференцию возможен только при наличии пригласительного билета!
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC; padding: 6mm 6mm; font-size: 5mm">
        <ul>
            <li>Не делайте копий билета и не передавайте его третьим лицам. Тот, кто первым предъявит билет на входе в
                здание церкви, первым получит право войти. Повторный проход по копии, дубликату или оригиналу билета
                невозможен. <br><br></li>
            <li>Детям в возрасте от 16 лет и старше для входа в здание необходимо получить пригласительный.<br><br></li>
            <li>Копия билета отправлена на Вашу почту, которую Вы указали при регистрации. Если Вы потеряли билет, Вы
                можете распечатать дубликат билета с почты и зайти в здание с ним. Рекомендуем Вам сохранить дубликат
                билета на компьютере.
            </li>
        </ul>
    </div>
    <div class="root-round-bottom text-center" style="border-top: 1mm solid #ff4002; background: #E7E7E7; padding: 6mm;">
        <strong class="text-uppercase">Остались вопросы?</strong>
        <div>Звоните по телефону:</div>
        <div>(495) 727-14-70</div>
    </div>
</div>
<div class="root-cut" style="top: 193mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4 rotate" style="top: 203mm;">
    <div style="background: #2F363E; padding: 5mm; padding: 3mm 0; font-size: 5mm;" class="text-white text-uppercase text-center root-round-top">
        Кеннет Коупленд
    </div>
    <div>
        <img src="/img/event/mgnc16/man.png" style="width: 89mm; height: 103mm;" alt="">
    </div>
    <div style="padding: 3mm 0; font-size: 5mm;" class="text-white text-uppercase text-center bg-orange">
        Внимание!
    </div>
    <div style="padding: 6mm 7mm 1mm; background: #E7E7E7; font-size: 4.5mm;" class="text-center">
        <br><br>  Пожалуйста, <br>не опаздывайте на конференцию! <br><br> Не забудьте взять с собой билет на парковку! <br><br><br><br><a style="color: #2F363E; text-decoration: none;" href="http://www.mgnc.ru/">www.mgnc.ru</a>
    </div>
    <div class="root-round-bottom" style="padding: 4mm 0 0; background: #2F363E;"></div>
</div>

<pagebreak />

<div class="root-col-4 rotate" style="top: 5mm;">
    <div class="text-center text-white root-round-top bg-orange text-uppercase" style="padding: 3mm 0; font-size: 5mm;">
        Парковочный билет
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC; padding: 3mm 5mm;">
        <div class="text-uppercase" style="color: #ddd; font-size: 8mm; font-family: 'PT Sans', sans-serif; visibility: hidden;">Дубликат
        </div>
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="text-uppercase" style="font-size: 6mm">Конференция</div>
                    <div style="font-size: 6mm">с участием</div>
                </td>
                <td class="text-right">
                    <img src="/img/event/mgnc16/logo.png" style="width: 20mm;" alt="">
                </td>
            </tr>
        </table>
        <img src="/img/event/mgnc16/title.png" style="width: 100%" alt="">
        <br><br>
        <div>
            <em style="font-size: 5mm"><strong>5 сентября</strong> в 11:00</em>
        </div>
    </div>
    <div style="background: #E7E7E7; padding: 2mm 5mm;">
        г. Москва <br> ул. Иркутская 11 корп. 1
    </div>
    <div style="background: #2F363E; padding: 5mm;" class="text-white">
        <div style="font-size: 8mm;">
            <?= $user->LastName; ?><br>
            <?= $user->FirstName; ?>
        </div>
        <div class="text-uppercase" style="margin-top: 15mm;">
            <?= $participant->Role->Title ?>
        </div>
    </div>
    <div class="text-center" style="background: #E7E7E7; padding: 2mm 5mm; font-size: 3.6mm;">
        Ваш штрих-код для входа на конференцию
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC; padding: 2mm 5mm;">
        <div style="padding: 5mm 0;" class="text-center">
            <barcode code="<?= $user->RunetId; ?>" type="C128A" size="1" height="1"/>
            <br>
            <div style="font-size: 3mm;"><?= $user->RunetId; ?></div>
        </div>
        <div class="text-center text-orange">
            При входе в здание с Вашего билета <br> будет считываться штрих-код
        </div>
    </div>
    <div class="bg-orange root-round-bottom" style="height: 4mm;"></div>
</div>
<div class="root-cut" style="top: 94mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4 rotate" style="top: 104mm;">
    <div class="text-center text-white root-round-top bg-orange text-uppercase" style="padding: 7mm 15mm; font-size: 5mm;">
        Вход в здание церкви на конференцию возможен только при наличии пригласительного билета!
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC; padding: 6mm 6mm; font-size: 5mm">
        <ul>
            <li>Не делайте копий билета и не передавайте его третьим лицам. Тот, кто первым предъявит билет на входе в
                здание церкви, первым получит право войти. Повторный проход по копии, дубликату или оригиналу билета
                невозможен. <br><br></li>
            <li>Детям в возрасте от 16 лет и старше для входа в здание необходимо получить пригласительный.<br><br></li>
            <li>Копия билета отправлена на Вашу почту, которую Вы указали при регистрации. Если Вы потеряли билет, Вы
                можете распечатать дубликат билета с почты и зайти в здание с ним. Рекомендуем Вам сохранить дубликат
                билета на компьютере.
            </li>
        </ul>
    </div>
    <div class="root-round-bottom text-center" style="border-top: 1mm solid #ff4002; background: #E7E7E7; padding: 6mm;">
        <strong class="text-uppercase">Остались вопросы?</strong>
        <div>Звоните по телефону:</div>
        <div>(495) 727-14-70</div>
    </div>
</div>
<div class="root-cut" style="top: 193mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4 rotate" style="top: 203mm;">
    <div style="background: #2F363E; padding: 5mm; padding: 3mm 0; font-size: 5mm;" class="text-white text-uppercase text-center root-round-top">
        Схема парковки
    </div>
    <div style="border-left: .3mm solid #ECECEC; border-right: .3mm solid #ECECEC;">
        <img src="/img/event/mgnc16/map.png" style="width: 88mm; height: 103mm;" alt="">
    </div>
    <div style="padding: 3mm 0; font-size: 5mm;" class="text-white text-uppercase text-center bg-orange">
        Внимание!
    </div>
    <div style="padding: 6mm 7mm 1mm; background: #E7E7E7; font-size: 4.5mm;" class="text-center">
        <br><br>  Пожалуйста, <br>не опаздывайте на конференцию! <br><br> Не забудьте взять с собой билет на парковку! <br><br><br><br><a style="color: #2F363E; text-decoration: none;" href="http://www.mgnc.ru/">www.mgnc.ru</a>
    </div>
    <div class="root-round-bottom" style="padding: 4mm 0 0; background: #2F363E;"></div>
</div>
