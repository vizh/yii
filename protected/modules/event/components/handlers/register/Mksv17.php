<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 17.02.17
 * Time: 16:42
 */

namespace event\components\handlers\register;


class Mksv17 extends Base
{

    public function getFromName()
    {
        return 'Мастер-класс «Сила Воли»';
    }

    public function showFooter()
    {
        return false;
    }
}