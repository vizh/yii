<?php

namespace connect\components\handlers\accept\user;

class Forinnovations16 extends Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Вы подтвердили встречу на форуме с '.$this->meeting->Creator->FullName;
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