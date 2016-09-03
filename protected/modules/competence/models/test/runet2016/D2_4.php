<?php
namespace competence\models\test\runet2016;

class D2_4 extends D2
{
    protected $baseCodeMarket = 'B1_1';

    protected $lastCode = 'E1_1';

    public $subMarkets = [
        '1' => 'Доля показов/трафика/кликов мобильных пользователей',
        '2' => 'Доля мобильных форматов/продуктов в обороте'
    ];
}
