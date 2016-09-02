<?php
namespace competence\models\test\runet2016;

class D1_8 extends D1LastBase
{
    protected $baseCodeMarket = 'B1_2';

    protected $lastCode = 'E1_2';
    
    public $subMarkets = [
        '1' => 'Хостинг (кроме облачного)',
        '2' => 'PaaS',
        '3' => 'IaaS',
    ];
}
