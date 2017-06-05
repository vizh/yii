<?php

namespace connect\components\handlers\decline\user;

class Forinnovations16En extends Forinnovations16
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'You have cancelled a business meeting with '.$this->meeting->Creator->getFullName();
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