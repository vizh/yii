<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.09.14
 * Time: 17:44
 */

namespace competence\models\test\runet2014;


class D4 extends D
{
    public function getTitle()
    {
        return sprintf(parent::getTitle(), $this->getSegment());
    }
} 