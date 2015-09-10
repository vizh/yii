<?php
namespace competence\models\test\runet2015;

class C9_8 extends C9 {
    protected $baseCodeMarket = 'B2_2';
    protected $nextCodes = [9=>'B3_9'];
    public $subMarkets = [
        '8_1' => 'Хостинг (кроме облачного)',
        '8_2' => 'Облачный хостинг'
    ];
}
