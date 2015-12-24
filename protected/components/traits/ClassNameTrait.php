<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.12.2015
 * Time: 19:06
 */

namespace application\components\traits;

trait ClassNameTrait
{
    /**
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }
}