<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\Participant;
use user\models\LinkEventPurpose;

class PurposesAction extends Action
{
    public function run()
    {
        $user = $this->getRequestedUser();

        $participant = Participant::model()
            ->byUserId($user->Id)
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($participant === null) {
            throw new Exception(202, [$user->RunetId]);
        }


        $links = LinkEventPurpose::model()
            ->byUserId($user->Id)
            ->byEventId($this->getEvent()->Id)
            ->with('Purpose')
            ->orderBy(['"Purpose"."Title"' => SORT_ASC])
            ->findAll();

        $result = [];
        foreach ($links as $link) {
            $result[] = $this
                ->getDataBuilder()
                ->createEventPuprose($link->Purpose);
        }

        $this->setResult($result);
    }
}
