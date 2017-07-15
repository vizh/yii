<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use user\models\User;
use Yii;

class SectionsAction extends Action
{
    public function run()
    {
        $data = $this
            ->getDataBuilder()
            ->createUserSections($this->getRequestedUser());

        $this->setResult($data);
    }
}
