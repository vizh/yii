<?php
namespace competence\models\test\runet2015;

class C9_11 extends C9 {
    protected $baseCodeMarket = 'B2_3';
    protected $nextCodes = [12=>'B3_12', 13=>'B3_13'];
    public $subMarkets = [
        '11_1' => 'Электронные платежные системы',
        '11_2' => 'Интернет-эквайринг',
    ];
}
