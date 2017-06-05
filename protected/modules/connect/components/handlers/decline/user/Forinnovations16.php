<?php

namespace connect\components\handlers\decline\user;

class Forinnovations16 extends Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Вы отменили встречу на форуме с '.$this->meeting->Creator->getFullName();
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'support@forinnovations.ru';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return 'Open Innovations 2016';
    }

    /**
     * @inheritdoc
     */
    public function getLayoutName()
    {
        return 'oi16';
    }
}