<?php
namespace competence\models\test\runet2016;


class C4_5_base extends C4 {
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
