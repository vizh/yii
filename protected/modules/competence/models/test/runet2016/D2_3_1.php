<?php
namespace competence\models\test\runet2016;

class D2_3_1 extends D2
{
    protected $baseCodeMarket = 'B1_1';

    protected $lastCode = 'E1_1';

    protected $nextCodes = ['3_2'=>'C1_3_2', '4'=>'C1_4'];

    public $subMarkets = [
        '1' => 'Доля показов/трафика/кликов мобильных пользователей',
        '2' => 'Доля мобильных форматов/продуктов в обороте'
    ];
}
