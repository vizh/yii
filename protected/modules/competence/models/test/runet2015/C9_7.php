<?php
namespace competence\models\test\runet2015;

class C9_7 extends C9 {
    protected $baseCodeMarket = 'B2_2';
    protected $nextCodes = [8=>'B3_8', 9=>'B3_9'];
    public $subMarkets = [
        '7_1' => 'Сегмент B2C',
        '7_2' => 'Сегмент B2B'
    ];
}
