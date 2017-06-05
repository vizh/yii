<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 15.04.15
 * Time: 16:02
 */

namespace event\components\handlers\register;

use mail\models\Layout;

class Mpsf16 extends Base
{

    public function getLayoutName()
    {
        return Layout::None;
    }

    public function getFromName()
    {
        return 'МПСФ';
    }

    /**
     * @inheritdoc
     */
    public function showUnsubscribeLink()
    {
        return false;
    }

    public function showFooter()
    {
        return false;
    }
}