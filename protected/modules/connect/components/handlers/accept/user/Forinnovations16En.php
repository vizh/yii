<?php

namespace connect\components\handlers\accept\user;

class Forinnovations16En extends Forinnovations16
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'You have accepted an invitation to hold a business meeting with '.$this->meeting->Creator->FullName;
    }

    public function getViewName()
    {
        return $this->getViewPath().'.forinnovations16-en';
    }

    /**
     * @inheritdoc
     */
    public function getLayoutName()
    {
        return 'oi16-en';
    }
}