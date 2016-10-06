<?php

namespace connect\components\handlers\accept\creator;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

class Forinnovations16En extends Forinnovations16
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getUser()->getFullName().' accepts your invitation to hold a business meeting';
    }

    public function getViewName()
    {
        return $this->getViewPath().'.forinnovations16-en';
    }
}