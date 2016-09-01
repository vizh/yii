<?php
namespace competence\models\test\runet2016;


class C4_5 extends C4 {
    use RouteMarket;

    protected $baseCodeMarket = 'B1_2';

    protected $lastCode = 'E1_2';

    protected $nextCodes = ['6'=>'C1_6', '7'=>'C1_7', '8'=>'C1_8'];

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
}
