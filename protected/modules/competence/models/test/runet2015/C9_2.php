<?php
namespace competence\models\test\runet2015;

class C9_2 extends C9 {
    protected $baseCodeMarket = 'B2_1';
    protected $nextCodes = [3=>'B3_3', 4=>'B3_4', 5=>'B3_5', 6=>'B3_6'];
    public $subMarkets = [
        '2_1' => 'Поисковая',
        '2_2' => 'Не поисковая (Perfomance, CPA, лидогенерация)',
        '2_3' => 'Таргетированная реклама в соцсетях'
    ];
}
