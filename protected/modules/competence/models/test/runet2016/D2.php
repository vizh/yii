<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;

class D2 extends Base
{
    public $subMarkets = [];

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2016.d1';
    }
}