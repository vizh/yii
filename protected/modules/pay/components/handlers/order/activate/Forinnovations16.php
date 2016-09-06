<?php
namespace pay\components\handlers\order\activate;

class Forinnovations16 extends Base
{
    public function getFrom()
    {
        return 'support@forinnovations.ru';
    }

    public function getFromName()
    {
        return 'Open Innovations 2016';
    }

    public function getLayoutName()
    {
        return 'oi16';
    }
}