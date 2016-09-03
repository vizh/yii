<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;
use competence\models\Result;

class D1LastBase extends D1
{
    use RouteMarket;

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
}