<?php
namespace competence\models\test\runet2016;

class D2_11 extends D2
{
    protected $baseCodeMarket = 'B1_3';

    protected $lastCode = 'E1_3';

    protected $nextCodes = ['12_1'=>'C1_12_1', '12_2'=>'C1_12_2'];

    public $subMarkets = [
        '1' => 'Доля заказов с мобильных устройств',
        '2' => 'Доля продаж с мобильных устройств',
    ];
}
