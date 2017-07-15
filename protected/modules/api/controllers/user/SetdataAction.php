<?php

namespace api\controllers\user;

use api\components\Action;
use event\models\UserData;

class SetdataAction extends Action
{
    public function run()
    {
        foreach ($this->getRequestedUsers() as $user) {
            UserData::set($this->getEvent(), $user, $this->getRequestParam('Attributes', []));
        }

        $this->setSuccessResult();
    }
}
