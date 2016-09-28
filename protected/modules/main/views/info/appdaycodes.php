<?php

/**
 * @var Participant[] $participants
 * @var ExternalUser[] $externalUsers
 */
use api\models\ExternalUser;
use event\models\Participant;

?>

<div class="container">
    <div class="row m-top_30">
        <div class="span12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>RUNET-ID</th>
                    <th>ФИО</th>
                    <th>Статус</th>
                    <th>Код</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($participants as $participant):
                    $user = $participant->User;
                   ?>
                    <tr>
                        <td><?=$user->RunetId?></td>
                        <td><?=$user->getFullName()?></td>
                        <td><?=$participant->Role->Title?></td>
                        <td><?=isset($externalUsers[$user->Id]) ? substr($externalUsers[$user->Id]->ExternalId, 0, 8) : ''?></td>
                    </tr>
                <?endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>