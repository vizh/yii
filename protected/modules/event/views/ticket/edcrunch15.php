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
<div style="position: absolute; top: 70mm; width: 100mm; left: 55mm; color: #464c9a;">
    <table style="width: 100%;">
        <tr>
            <td style="color: #464c9a; font-weight: bold; font-size: 9mm; line-height: 1.2; text-align: center; height: 35mm; vertical-align: middle;">
                <?=$user->getFullName()?>
            </td>
        </tr>
    </table>
</div>
<div style="text-align: center;">
    <img src="/img/ticket/edcrunch15/sertificate.jpg" />
</div>