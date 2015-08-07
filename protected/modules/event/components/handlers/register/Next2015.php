<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 04.08.2015
 * Time: 16:55
 */

namespace event\components\handlers\register;


class Next2015 extends Base
{
    /**
     * Повторять письмо при возникновение события
     * @return bool
     */
    protected function getRepeat()
    {
        return false;
    }
}