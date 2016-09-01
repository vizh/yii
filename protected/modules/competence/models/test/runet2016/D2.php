<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;

class D2 extends Base
{
    use RouteMarket;
    
    public $subMarkets = [];

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2016.d1';
    }

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
}