<?php
namespace competence\models\test\runet2016;

class D1_12_1 extends D1
{
    use RouteMarket;
    
    protected $baseCodeMarket = 'B1_3';

    protected $lastCode = 'E1_3';

    protected $nextCodes = ['12_2'=>'C1_2_2'];
    
    public $subMarkets = [
        '1' => 'Рынок онлайн-платежей (электронные платежные системы)',
        '2' => 'Рынок онлайн-платежей (интернет-эквайринг)'
    ];

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
}
