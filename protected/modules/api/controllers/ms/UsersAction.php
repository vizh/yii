<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.05.2015
 * Time: 0:17
 */

namespace api\controllers\ms;

use api\components\Action;
use api\models\ExternalUser;
use event\models\Participant;

class UsersAction extends Action
{
    public function run()
    {
        $result = [];
        $participants = Participant::model()->byEventId($this->getEvent()->Id)->with(['User'])->findAll();
        foreach ($participants as $participant) {
            $externalUser = ExternalUser::model()->byUserId($participant->UserId)->find();
            if ($externalUser !== null) {
                $item = new \stdClass();
                $item->ID = $externalUser->ExternalId;
                $item->SID = $externalUser->User->RunetId;
                $result[] = $item;
            }
        }
        $this->setResult($result);
    }
}