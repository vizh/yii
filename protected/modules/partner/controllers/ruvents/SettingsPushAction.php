<?php
namespace partner\controllers\ruvents;

use event\models\Participant;
use partner\components\Action;

class SettingsPushAction extends Action
{
    public function run()
    {
        $pushedCount = 0;

        $participants = Participant::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll();

        foreach ($participants as $participant) {
            $user = $participant->User;
            if ($user->hasPhoto()) {
                $user->refreshUpdateTime(true);
                $pushedCount++;
            }
        }

        echo "Пропихнуто $pushedCount посетителей";
    }
}