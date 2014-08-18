<?php

use user\models\User;

/**
 * @var User $user
 */
?>
<body style="width: 850px;">

<table style="color: #000; font-size: 14px; margin: 0 auto;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <img style="display: block;" src="/img/event/edcrunch14/top.jpg" />
        </td>
    </tr>
    <tr>
        <td style="position: relative; height: 183px;">
            <img style="display: block;" src="/img/event/edcrunch14/mid.jpg" />
            <table style="height: 183px; width: 480px; top: 0; left: 110px; position: absolute;">
                <tr>
                    <td>
                        <img style="display: block;" src="/img/event/edcrunch14/ticket.jpg" width="180" />
                    </td>
                    <td rowspan="3">
                        <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user, 120)?>"/>
                        <p style="padding: 0 0 0 17px; margin: -15px 0 0; font-size: 11px;">RUNET&mdash;ID <a href="<?=$user->getUrl();?>" style="color: #339dd5; text-decoration: none;"><?=$user->RunetId;?></a></p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 80px; width: 350px; vertical-align: bottom; font-size: 28px;"><?=$user->getFullName();?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 0 0 0; font-size: 16px; font-weight: 700; vertical-align: top;">
                        <?if ($user->getEmploymentPrimary() !== null):?>
                            <?=$user->getEmploymentPrimary()->Company->Name;?>
                        <?endif;?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <img style="display: block;" src="/img/event/edcrunch14/bottom.jpg" />
        </td>
    </tr>
</table>

</body>
