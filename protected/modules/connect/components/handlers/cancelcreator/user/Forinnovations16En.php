<?php

namespace connect\components\handlers\cancelcreator\user;

class Forinnovations16En extends Forinnovations16
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->meeting->Creator->getFullName().' has cancelled a business meeting';
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