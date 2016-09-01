<?php
namespace competence\models\test\runet2016;

class D1_6 extends D1
{
    use RouteMarket;
    
    protected $baseCodeMarket = 'B1_2';

    protected $lastCode = 'E1_2';

    protected $nextCodes = ['7'=>'C1_7', '8'=>'C1_8'];
    
    public $subMarkets = [
        '1' => 'Хостинг (кроме облачного)',
        '2' => 'PaaS',
        '3' => 'IaaS',
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
