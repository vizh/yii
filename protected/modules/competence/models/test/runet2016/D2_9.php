<?php
namespace competence\models\test\runet2016;

class D2_9 extends D2
{
    protected $baseCodeMarket = 'B1_3';

    protected $lastCode = 'E1_3';

    protected $nextCodes = ['10'=>'C1_10', '11'=>'C1_11', '12_1'=>'C1_2_1', '12_2'=>'C1_2_2'];
    
    public $subMarkets = [
        '1' => 'Доля заказов с мобильных устройств',
        '2' => 'Доля продаж с мобильных устройств',
    ];
}
