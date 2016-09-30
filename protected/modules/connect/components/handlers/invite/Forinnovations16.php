<?php

namespace connect\components\handlers\invite;

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
        return $this->meeting->Creator->getFullName().' предлагает Вам встретится на форуме';
    }
}