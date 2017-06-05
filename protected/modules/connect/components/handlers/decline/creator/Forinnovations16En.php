<?php

namespace connect\components\handlers\decline\creator;

class Forinnovations16En extends Forinnovations16
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getUser()->getFullName().' hasn\'t accepted your invitation to hold a business meeting';
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