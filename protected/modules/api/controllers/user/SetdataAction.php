<?php
namespace api\controllers\user;

use api\components\Action;
use event\models\UserData;

class SetdataAction extends Action
{
    public function run()
    {
        UserData::set(
            $this->getEvent(),
            $this->getRequestedUser(),
            $this->getRequestParam('Attributes', [])
        );

        $this->setSuccessResult();
    }
}