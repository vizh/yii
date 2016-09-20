<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

use user\models\User;
use event\models\Event;
use event\models\Participant;
?>
<div style="position: absolute; top: 130mm; width: 100mm; left: 55mm; color: #000;">
    <table style="width: 100%;">
        <tr>
            <td style="color: #000; font-weight: bold; font-size: 6mm; line-height: 1.2; text-align: center; height: 35mm; vertical-align: middle;">
                <?= mb_strtoupper($user->FirstName);?> <?= mb_strtoupper($user->FatherName);?> <?= mb_strtoupper($user->LastName);?>
            </td>
        </tr>
    </table>
</div>
<div style="text-align: center;">
    <img src="/img/ticket/edcrunch16/edcrunch16.png" />
</div>