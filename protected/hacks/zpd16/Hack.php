<?php

namespace application\hacks\zpd16;

use application\hacks\AbstractHack;
use event\models\Participant;
use event\models\UserData;

class Hack extends AbstractHack
{
    public function onParticipantSaved(Participant $participant)
    {
        UserData::set($participant->Event, $participant->User, [
            'Password' => rand(0, 1000)
        ]);
    }

}