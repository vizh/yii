<?php
namespace competence\models\test\runet2015;

class C9_12 extends C9
{
    protected $baseCodeMarket = 'B2_3';
    protected $nextCodes = [13=>'B3_13'];
    public $subMarkets = [
        '12_1' => 'Билеты (транспорт)',
        '12_2' => 'Туры',
        '12_3' => 'Бронирование отелей, хостелов, аппартаментов'
    ];
}
