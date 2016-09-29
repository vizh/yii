<?php
namespace competence\models\test\runet2016;

class D2_15 extends D2
{
    protected $baseCodeMarket = 'B1_4';

    protected $lastCode = 'E1_4';

    protected $nextCodes = ['16'=>'C1_16'];
    
    public $subMarkets = [
        '1' => 'Доля мобильных пользователей',
        '2' => 'Доля покупок с мобильных устройств',
    ];
}
