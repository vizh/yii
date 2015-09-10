<?php
namespace competence\models\test\runet2015;

class C9_3 extends C9 {
    protected $baseCodeMarket = 'B2_1';
    protected $nextCodes = [4=>'B3_4', 5=>'B3_5', 6=>'B3_6'];
    public $subMarkets = [
        '3_1' => 'Продвижение в соцмедиа',
        '3_2' => 'Аналитика соцмедиа и Social CRM'
    ];
}
