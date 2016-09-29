<?php

namespace application\hacks\nobel16\actions;

use partner\components\Action;
use ruvents\models\Visit;

class Nobel16Action extends Action
{
    public function run()
    {
        header('Content-Type: text/csv; charset=utf-8');

        $visits = Visit::model()
            ->byEventId($this->getEvent()->Id)
            ->orderByCreationTime(SORT_ASC)
            ->with('User')
            ->findAll();

        foreach ($visits as $visit) {
            if (isset($filteredVisits[$visit->UserId]) === false) {
                $filteredVisits[$visit->UserId] = true;
                printf("\"%s\"\n", implode('";"', [
                    $visit->User->RunetId,
                    $visit->User->getFullName(),
                    $visit->User->Email,
                    $visit->CreationTime,
                    $visit->MarkId
                ]));
            }
        }
    }
}