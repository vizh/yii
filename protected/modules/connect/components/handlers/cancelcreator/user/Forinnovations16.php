<?php

namespace connect\components\handlers\cancelcreator\user;

class Forinnovations16 extends Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->meeting->Creator->getFullName().' не сможет встретится с Вами на форуме';
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