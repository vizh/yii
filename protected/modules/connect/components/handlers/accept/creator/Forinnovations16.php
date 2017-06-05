<?php

namespace connect\components\handlers\accept\creator;

class Forinnovations16 extends Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getUser()->getFullName().' подтверждает возможность встречи на форуме';
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