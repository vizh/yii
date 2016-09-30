<?php

namespace connect\components\handlers\accept;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

class Forinnovations16 extends Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getUser()->getFullName().' подтверждает возможность встречи на форуме';
    }
}