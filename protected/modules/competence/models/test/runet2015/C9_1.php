<?php
namespace competence\models\test\runet2015;

class C9_1 extends C9 {
    protected $baseCodeMarket = 'B2_1';
    protected $nextCodes = [2=>'B3_2', 3=>'B3_3', 4=>'B3_4', 5=>'B3_5', 6=>'B3_6'];
    public $subMarkets = [
        '1_1' => 'Веб-разработка (в т.ч мобильная, адаптивная)',
        '1_2' => 'Разработка мобильных приложений'
    ];
}
